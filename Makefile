.PONY: start-local

build-app:
	docker build . -t project-ddd
	docker run --rm --volume ${PWD}:/app project-ddd composer install

start-local:
	docker run --rm -d \
	    --name project-ddd-ps \
	    --volume ${PWD}:/app \
	    -p 80:8080 \
	    project-ddd \
	    php -S 172.17.0.2:8080 apps/mooc/backend/public/index.php

http-get-health-check:
	curl http://172.17.0.2:8080/health-check

http-get-greet:
	curl http://172.17.0.2:8080/greet?name=manolo

