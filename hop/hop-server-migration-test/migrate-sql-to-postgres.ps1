# Define the Docker command parameters
$dockerImage = "apache/hop:latest"  # Replace <tag> with the specific Apache Hop version
$containerName = "hop-server"
$localDir = "./hop-mount"  # Replace with your actual local directory path
$volumeMapping = "$($localDir):/files"

# Environment variables
$envVars = @(
    "HOP_LOG_LEVEL=Basic",
    "HOP_FILE_PATH='${PROJECT_HOME}/parallel-workflow.hwf'",
    "HOP_PROJECT_FOLDER=/files/project",
    "HOP_PROJECT_NAME=referent",
    "HOP_ENVIRONMENT_NAME=referent-test",
    "HOP_ENVIRONMENT_CONFIG_FILE_NAME_PATHS=/files/project-config.json",
    "HOP_RUN_CONFIG=local"
)

# Construct the Docker run command
$dockerCommand = "docker run -it --rm --name $containerName "
foreach ($envVar in $envVars) {
    $dockerCommand += "--env $envVar "
}
$dockerCommand += "-v $volumeMapping $dockerImage"

# Execute the Docker command
Invoke-Expression $dockerCommand