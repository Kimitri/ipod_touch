IMAGE_NAME=kimitri/home-data
IMAGE_TAG=1.1.0
PORT=8069

.PHONY: build
build:
	docker build -t $(IMAGE_NAME) .

.PHONY: run
run: build
	docker run -d -p $(PORT):80 --env-file .env $(IMAGE_NAME) 

.PHONY: stop
stop:
	docker stop $(shell docker ps --filter "ancestor=$(IMAGE_NAME)" --format "{{.ID}}")

.PHONY: release
release:
	docker login
	docker buildx build --platform linux/arm64 -t $(IMAGE_NAME):$(IMAGE_TAG) --push .
