.PHONY: assets

assets:
	vite build
	cd ../.. && php artisan vendor:publish --tag=moonshine-advanced --force
