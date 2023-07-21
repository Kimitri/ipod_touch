IMAGE_NAME=kimitri/home-data
IMAGE_TAG=1.0.2

release:
	docker login
	docker buildx build --platform linux/arm64 -t $(IMAGE_NAME):$(IMAGE_TAG) --push .
