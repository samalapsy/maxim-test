# MAXIM Backend Engineering Task 1 
Create a small set of rest API endpoints using any of the preferred programming languages mentioned above to do the following 
* List an array of movies containing the name, opening crawl and comment count
* Add a new comment for a movie 
* List the comments for a movie 
* Get list of characters for a movie 

### General requirements 
* The application should have basic documentation that lists available endpoints and methods along with their request and response signatures 
* The exact api design in terms of total number of endpoints and http verbs is up to you
* Keep your application source code on a public Github repository 
* Deploy the API endpoints and provide a live demo URL of the API documentation. Heroku is a good option. 
* Bonus, but not mandatory, if you can dockerize the development environment.

### Data requirements 
* The movie data should be fetched online from  **[<https:/swapi.dev>](<https://swapi.dev>)** 
* Movie names in the movie list endpoint should be sorted by release date from earliest to newest and each movie should be listed along with opening crawls and count of comments. 
* Data fetched from **[<https://swapi.dev>](<https://swapi.dev>)** should be cached with Redis and then accessed from the cache for subsequent requests. 
* Comments should be stored in a Postgres database. 
* Error responses should be returned in case of errors. 

### Character list requirements 
* Endpoint should accept sort parameters to sort by one of name, gender or height in ascending or descending order. 
* Endpoint should also accept a filter parameter to filter by gender 
* The response should also return metadata that contains the total number of characters that match the criteria along with the total height of the characters that match the criteria 
* The total height should be provided both in cm and in feet/inches. For instance, 170cm makes 5ft and 6.93 inches. 

### Comment requirements 
* Comment list should be retrieved in reverse chronological order 
* Comments should be retrieved along with the public IP address of the commenter and UTC date & time they were stored 
* Comment length should be limited to 500 characters 


## My Solution
The API can be accesed on this url - https://maxim-test-dcbfcbcbf751.herokuapp.com/api/
[Open Postman Documentation](https://documenter.getpostman.com/view/1569457/2s93zB5giJ#1a5b0e66-81c0-492d-9cef-0421386ed310)


### Tech Stack
* PHP (Laravel) - used for the API development.
* Redis (In-memory storage) - Used to store the cached data.
* PostgreSql (Database) - Used to store the all comments.


### Custom Environment Configuration 
| Env Name          |   Value                   |   Description                                                                                                                  |
|-------------------|---------------------------|--------------------------------------------------------------------------------------------------------------------------------|
| BASE_API_URL      | https://swapi.dev/api/    | SWAPI Base API url                                                                                                             |
| RATE_LIMIT        | 20                        | The minutes with within which a speicfied number of calls can be made. Please note that this value can be update               |
| MAX_ATTEMPT       | 1                         | Total number of API calls that can be made by within a specific time. Please note that this value can be update                |
| CACHE_DURATION    | 5000                      | Total number of seconds the cache variable should last long for. Please note that this value can be update                     |


### The Approach
As required in the all APi calls made to the third party APIs are cached into Redis. In addition to that,  A `1 request per 20 minutes` throttle was place on the add comment API, meaning an ip address can only add 1 comment per 20 minutes to a movie.



### SetUp
Please run the following commands after pulling the codebase
- `composer install`
- Add your postgres DB credentials to the `.env` file
- Ensure you also have redis installed on your local PC


### TEST
Unfortunately, no test case were written for now.

