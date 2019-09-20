<p align="center">
  <a href="http://codely.tv">
    <img src="http://codely.tv/wp-content/uploads/2016/05/cropped-logo-codelyTV.png" width="192px" height="192px"/>
  </a>
</p>

<p align="center">Template to start from scratch a new Php project using DDD as architecture.</p>

## Installation

Use the dependency manager [Composer](https://getcomposer.org/) to create a new project.

```
composer create-project codelytv/ddd-skeleton
```

## Usage with Docker

Just run:

```
make build
```

Then go to `http://localhost:8030/health-check` to check all is ok.

## Usage from local

First of all you should execute 

```
make prepare-local
```

And then start local environment:

```
make start-local
```

And then going to `http://localhost:8030/health-check` to check all is ok.

## Contributing
There are some things missing feel free to add this if you want! If you want
some guidelines feel free to contact us :)
