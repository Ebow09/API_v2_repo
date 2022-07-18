# Description
API to download exchange rates from an exchange rate provider. A token is provided by the provider to allow connection to their API to get the exchange rates.
The API downloads the exchange rates and stores them in a table. The table has 2 values since and until. The until date field is not populated for the last dates data pulled by the API. When the next pull takes place the until field is populated with the current date. The current rates are those which do not have NULL until fields. Some test cases have been provided.

## Considerations and possible expansion
- Create a separate layer to store base values so when any changes are made to the base values the processing classes are untouched
- 


## Installation Requirements
- PHP 8.0 
- Lumen 9.0
- MySQL
- Xampp
- Composer 2.0

After configuration, clone this project to your htdocs folder
