#!/bin/bash
set -e # Exit with nonzero exit code if anything fails

docker login -u="$DOCKER_USERNAME" -p="$DOCKER_PASSWORD"
docker build -t $DOCKER_USERNAME/travis-ci-build:php-sf-$RELEASE -f resources/docker/build/php/Dockerfile .
docker push $DOCKER_USERNAME/travis-ci-build:php-sf-$RELEASE