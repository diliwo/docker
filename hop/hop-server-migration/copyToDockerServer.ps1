# SSH Information
$sshHost = "SRV-D-PHOTON01"
$sshUser = "ladmin"
$sshPassword = "Ph0ton-2023!"
$localFilePath = "./*"
$remoteFilePath = "/var/tmp/migration-postgres-sql"

# Path to PSCP
$pscpPath = "./pscp.exe"

# Command
$pscpCommand = "& `"$pscpPath`" -pw $sshPassword `"$localFilePath`" $sshUser@${sshHost}:`"$remoteFilePath`""

# Execute the command
Invoke-Expression $pscpCommand