#!/bin/bash

# Check if target directory is provided
if [ -z "$1" ]; then
  echo "Usage: $0 <target_directory>"
  exit 1
fi

TARGET_DIR="$1"
OUTPUT_DIR="${TARGET_DIR}/jpgs"

# Create the output directory if it doesn't exist
mkdir -p "$OUTPUT_DIR"

# Find and convert .heic files to .jpg
find "$TARGET_DIR" -type f -iname "*.heic" | while read -r heic_file; do
  # Get the base name of the HEIC file (without path or extension)
  base_name=$(basename "$heic_file" .heic)
  
  # Generate output file path in the converted_jpgs subfolder
  jpg_file="${OUTPUT_DIR}/${base_name}.jpg"

  # Convert the HEIC file to JPG
  echo "Converting: $heic_file -> $jpg_file"
  magick magick "$heic_file" "$jpg_file"
  
  if [ $? -eq 0 ]; then
    echo "Successfully converted: $heic_file"
  else
    echo "Failed to convert: $heic_file"
  fi
done

echo "All conversions completed. Converted files are in: $OUTPUT_DIR"

