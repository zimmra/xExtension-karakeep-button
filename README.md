# FreshRSS Karakeep Button
A [FreshRSS](https://freshrss.org/) extension which adds a [Karakeep](https://karakeep.app) sharing integration.

With this extension you can simply press the Karakeep Button next to an article or a custom keyboard shortcut to share it with Karakeep. Everything else happens in the background while you can continue reading articles without any further interruptions.

## Download and setup
1. Download the [latest release](https://github.com/zimmra/xExtension-karakeep-button/releases)
2. Extract and upload it to the `./extensions` folder of your FreshRSS installation
3. Go to `<karakeep_intance_url>/settings/api-keys`
4. Create a new API Key with the name of your choice
5. Enter your Karakeep instance url in the Karakeep Button extension settings
6. Enter your `api_key` in the Karakeep Button extension settings
7. Press "Connect to Karakeep"
8. *Optional Set a custom keyboard shortcut*

## Karakeep API Error codes
If you get errors while trying to connect to Karakeep, please check the [Karakeep OpenAPI specification](https://docs.karakeep.app/API/karakeep-api).

## Contributing

### Translations
If you'd like to translate the extension to another language please file a pull request. I'd be happy to merge it!

### Development
For local development pull the repository. The prerequisite is [Docker](https://www.docker.com/) installed.

Go to the repository root folder and run `docker compose up` that will start a local [FreshRSS](https://www.freshrss.org/) instance running `http://localhost:8080/` as well as [Karakeep](https://karakeep.app)  instance running at `http://localhost:3000/`.

Complete it's installation and navigate to Extensions, where you have to enable `Karakeep Button`.

All changes in the PHP files are loaded with each page refresh.

## Credits

This extension is based on [freshrss-pocket-button](https://github.com/christian-putzke/freshrss-pocket-button) and [xExtension-wallabag-button](https://github.com/Joedmin/xExtension-wallabag-button) and re-branded for Karakeep.

Thank you very much [Christian Putzke](https://github.com/christian-putzke) and [Joedmin](https://github.com/Joedmin) for creating the original extensions.

Original Karakeep icon is used from the original [Karakeep repository](https://github.com/karakeep-app/karakeep) and the outlined version was made using [Inskape](https://inkscape.org/).
