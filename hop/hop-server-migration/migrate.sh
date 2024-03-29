#!/bin/bash

# Define the Docker command parameters
dockerImage="apache/hop:latest"  # Replace <tag> with the specific Apache Hop version
containerName="hop-server"
localDir="./hop-mount"  # Replace with your actual local directory path
volumeMapping="$localDir:/files"

# Environment variables
envVars=(
    "HOP_LOG_LEVEL=Basic"
    "HOP_FILE_PATH='${PROJECT_HOME}/migration-sql-to-postgres.hwf'"
    "HOP_PROJECT_FOLDER=/files"
    "HOP_ENVIRONMENT_CONFIG_FILE_NAME_PATHS=/files/project-config.json"
    "HOP_RUN_CONFIG=local"
    "HOP_RUN_PARAMETERS=PARAM_LOG_MESSAGE=Hello,PARAM_WAIT_FOR_X_MINUTES=1"
)

# Construct the Docker run command
dockerCommand="docker run -it --rm --name $containerName"
for envVar in "${envVars[@]}"; do
    dockerCommand+=" --env $envVar"
done
dockerCommand+=" -v $volumeMapping $dockerImage"

# Execute the Docker command
eval $dockerCommand