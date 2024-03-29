
function Copy-Pentaho-Objects{
    [CmdletBinding()]
    Param(
        [Parameter(Mandatory = $True,
        Position = 0,
        ParameterSetName = "Set1")]
        [String]$server,
        [Parameter(Mandatory = $True,
        Position = 1,
        ParameterSetName = "Set1")]
        [String]$path
    )
    $pentahoObjectTransferSession = New-PSSession -ComputerName $server
    # Create remote folder if not exists
    Invoke-Command -Session $pentahoObjectTransferSession -ScriptBlock {
        param($path)
        New-Item -ItemType Directory -Path $path -Force
    } -ArgumentList $path
    #Copy all files
    $files = Get-ChildItem *.ktr,*.kjb,*.sql
    foreach ($file in $files) {
        $filename = $file.Name
        Copy-item -Path ".\$filename" -Destination "$path\$filename" -ToSession $pentahoObjectTransferSession    
    }
    Remove-PSSession $pentahoObjectTransferSession
    
}

function Launch-Migration()
{
    [Cmdletbinding()] 
    Param(
        [Parameter(Mandatory = $True,
        Position = 0,
        ParameterSetName = "Set1")]
        [String]$pentahoServername,
        [Parameter(Mandatory = $True,
        Position = 1,
        ParameterSetName = "Set1")]
        [String]$pentahoFolderPath,
        [Parameter(Mandatory = $True,
        Position = 2,
        ParameterSetName = "Set1")]
        [String]$jobFullPath,
        [Parameter(Mandatory = $True,
        Position = 3,
        ParameterSetName = "Set1")]
        [String]$pgHostname,
        [Parameter(Mandatory = $True,
        Position = 4,
        ParameterSetName = "Set1")]
        [String]$pgDatabaseName,
        [Parameter(Mandatory = $True,
        Position = 5,
        ParameterSetName = "Set1")]
        [String]$pgUsername,
        [Parameter(Mandatory = $True,
        Position = 6,
        ParameterSetName = "Set1")]
        [String]$pgPassword

    )
    $migrationExecutionSession = New-PSSession -ComputerName $pentahoServername
    Invoke-Command -Session $migrationExecutionSession -ScriptBlock {
        param($pentahoFolderPath, $jobFullPath,$pgHostname, $pgDatabaseName, $pgUsername, $pgPassword)
        Set-Location $pentahoFolderPath;
        $cmd = 'kitchen.bat /file:"' + $jobFullPath + '"/param:PgHostname='+ $pgHostname + '" "/param:PgUsername='+$pgUsername `
        +'"/param:PgPassword=' +$pgPassword + '" "/param:PgDatabaseName='+$pgDatabaseName +'"'
        $cmd | cmd
    } -ArgumentList $pentahoFolderPath, $jobFullPath, $pgHostname, $pgDatabaseName, $pgUsername, $pgPassword

    Remove-PSSession $migrationExecutionSession
}
function Test-PgDatabase-Exists()
{
    [Cmdletbinding()] 
    Param(
    [Parameter(Mandatory = $True,
        Position = 0,
        ParameterSetName = "Set1")]
    [String]$server,
    [Parameter(Mandatory = $True,
        Position = 1,
        ParameterSetName = "Set1")]
    [String]$username,
    [Parameter(Mandatory = $True,
        Position = 2,
        ParameterSetName = "Set1")]
    [String]$password,
    [Parameter(Mandatory = $True,
        Position = 3,
        ParameterSetName = "Set1")]
    [String]$dbname
    )

    $tagForDbExists = "DB_EXISTS";
    $sessionTestDbExists = New-PSSession -ComputerName $server 
    $result = Invoke-Command -Session $sessionTestDbExists -ScriptBlock {
        param($username, $password, $dbName, $tag)
        $env:PGPASSWORD = "$password"
        psql -U $username -t -c "select '$tag' from pg_catalog.pg_database where datname='$dbName'" 
    } -ArgumentList $username, $password, $dbname, $tagForDbExists

    Remove-PSSession $sessionTestDbExists
    foreach ($line in $result) {
        if ($line.Trim() -eq $tagForDbExists )
        {
            return $true
        }
    }
    return $false

    
}



$config = Get-Content config.json | ConvertFrom-Json 
$pentahoServername = $config.Pentaho.Hostname;
$pentahoFolderPath = $config.Pentaho.FolderPath;
$pentahoJobFileName  = $config.Pentaho.JobFileName;
$pentahoProgramFolderPath = $config.Pentaho.ProgramFolderPath;
$pentahoJobFolderPath = $config.Pentaho.JobFolderPath;
$pgServername = $config.Postgres.Hostname;
$pgUsername = $config.Postgres.Username;
$pgPassword = $config.Postgres.Password;
$pgDbname = $config.Postgres.DatabaseName;
$session = New-PSSession -ComputerName $pentahoServername 


$isPgDatabaseExists = Invoke-Command  -ScriptBlock ${Function:Test-PgDatabase-Exists} -ArgumentList $pgServername, $pgUsername, $pgPassword, $pgDbname

if ($isPgDatabaseExists -eq $true)
{
    Write-Host "$pgDbname already exists on $pgServername"
    return;
}
Write-Host "$pgDbname not exists on $pgServername"

Invoke-Command -ScriptBlock ${Function:Copy-Pentaho-Objects} -ArgumentList $pentahoServername,$pentahoJobFolderPath

$jobFullPath = "$pentahoJobFolderPath\\$pentahoJobFileName"
Invoke-Command -ScriptBlock ${Function:Launch-Migration} -ArgumentList $pentahoServername, $pentahoProgramFolderPath,$jobFullPath,$pgServername,$pgDbname,$pgUsername,$pgPassword

Remove-PSSession $session
