#!/usr/bin/env bash

mogrify -format bmp -background white -channel R,G,B -flatten -grayscale Rec709Luminance "*.png"
