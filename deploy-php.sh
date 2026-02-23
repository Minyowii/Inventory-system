#!/bin/bash

# Script untuk deploy PHP project ke GitHub Container Registry

# Config
IMAGE_NAME="inventory-system-php"
GITHUB_USERNAME="minyowii"
VERSION="1.0.0"

echo "Building PHP Inventory System Docker image..."

# Build Docker image
docker build -t ghcr.io/$GITHUB_USERNAME/$IMAGE_NAME:$VERSION .
docker build -t ghcr.io/$GITHUB_USERNAME/$IMAGE_NAME:latest .

# Login ke GitHub Container Registry (jika mau push)
# echo $GHCR_TOKEN | docker login ghcr.io -u $GITHUB_USERNAME --password-stdin

# Push image (optional)
# docker push ghcr.io/$GITHUB_USERNAME/$IMAGE_NAME:$VERSION
# docker push ghcr.io/$GITHUB_USERNAME/$IMAGE_NAME:latest

echo "Build completed!"
echo "To run: docker-compose up -d"