#!/usr/bin/env bash

mogrify -format png -background white -flatten -colorspace gray -dither FloydSteinberg "*.png"
