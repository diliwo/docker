Get-ChildItem -Filter *.release.php | ForEach-Object {
 $NewName = $_.Name -replace ".release",""
 $Destination = Join-Path -Path $_.Directory.FullName -ChildPath $NewName
 Move-Item -Path $_.FullName -Destination $Destination -Force
}