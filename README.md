## Blog Post App
### Run 
1. git clone https://github.com/alexeydemin/blog-post
2. cd blog-post
3. docker-compose up -d
4. docker-compose run app php artisan migrate
5. docker-compose run app php artisan db:seed

- GET http://localhost:8000/api/comments - List
- POST http://localhost:8000/api/comments - Create, e.g. `{"name":"Sally", "message": "Hi there"}`
- PATCH http://localhost:8000/api/comments/23 - Edit, e.g. `{"name":"Sally", "message": "Hi there"}`
- DELETE http://localhost:8000/api/comments/5 - Delete

Or just export `./blog-post-insomnia` file to your Insomnia API Client

### Test
docker-compose run app php artisan test
