#!/bin/bash
echo hello world
#!/bin/bash

#! Extracts frames for all films in designated dir, creates a new dir for each film and 
#! places the extracted images and matlab scripts there

for file in Thesis5/*.mp4; do
    destination="Output${file%.*}";
    mkdir -p "$destination"; 
    ffmpeg -i "$file" -vf fps=1/6 "$destination/image-%d.jpeg";
    cp /Users/Akash/Desktop/Bash/Main.m /Users/Akash/Desktop/Bash/Output${file%.*}
    cp /Users/Akash/Desktop/Bash/rgb2hex.m /Users/Akash/Desktop/Bash/Output${file%.*}
    cp /Users/Akash/Desktop/Bash/names.txt /Users/Akash/Desktop/Bash/Output${file%.*}
done
