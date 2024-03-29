# PowerShell Script to Execute a Bash Script on a Remote Linux Machine

# Define SSH Connection Parameters
$linuxHost = "SRV-D-PHOTON01"
$linuxUser = "ladmin"

# Path to the Bash script on the Linux machine
$bashScriptPath = "/var/tmp/migration-postgres-sql/migrate.sh"  # Replace with the path to your Bash script

$sshKeyPath = "./key"

# Create a PowerShell SSH session to the Linux machine
try {
    $session = New-PSSession -HostName $linuxHost -UserName $linuxUser -SSHTransport -KeyFilePath $sshKeyPath
    Write-Host "Connected to $linuxHost"
} catch {
    Write-Error "Failed to connect to ${linuxHost}: $_"
    exit
}

# Define the script block to execute
$scriptBlock = {
    param($scriptPath)
    bash -c $scriptPath
}

# Execute the Bash script
try {
    Invoke-Command -Session $session -ScriptBlock $scriptBlock -ArgumentList $bashScriptPath
    Write-Host "Bash script executed successfully."
} catch {
    Write-Error "Failed to execute the script: $_"
}

# Close the session
Remove-PSSession $session
Write-Host "Session to $linuxHost closed."