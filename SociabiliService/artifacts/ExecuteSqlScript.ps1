[CmdletBinding()]
param (
    [Parameter()] [string] $SqlScriptPath
)
$config = Get-Content .\ExecuteSqlScript.json | ConvertFrom-Json
$connectionString = $config.ConnectionString;

Add-Type -Path ./Oracle.ManagedDataAccess.dll
$con = New-Object Oracle.ManagedDataAccess.Client.OracleConnection($connectionString);

$cmd = new-object Oracle.ManagedDataAccess.Client.OracleCommand;
$cmd.Connection = $con;
$cmd.CommandType = [System.Data.CommandType]::Text;
$con.Open()

$sql = Get-Content -Path $SqlScriptPath -Encoding UTF8 -Raw;
$cmd.CommandText = $sql;
$cmd.ExecuteNonQuery();

$con.Close();    
