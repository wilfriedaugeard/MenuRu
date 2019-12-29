# MenuRu

<p align="center-left">
  <img alt="Version : 1.0.1-beta" src="https://img.shields.io/badge/version-1.0.1_beta-green" />
  <img alt="php" src="https://img.shields.io/badge/php-v5.6.40-blue?logo=php&logoColor=white" />
  <img alt="mit" src="https://img.shields.io/badge/license-MIT-yellow" />
	
</p><br/>

This is a simple API done in PHP. <br>Goal is to retrieve all menus from Bordeaux University restaurant from the source code of their website in order to put them in a JSON file.

## Installation
### Clone
Clone this repository to your local machine 
```shell
$ git clone https://github.com/wilfriedaugeard/Reversi_AI/
```

## Example of JSON file render

```json
{
    "nb_days": 1,
    "date": {
        "25 juin 2019": {
            "Petit d\u00e9jeuner": {
                "Pas de service": []
            },
            "D\u00e9jeuner": {
                "CHAINE TRADITIONNELLE": {
                    "Entr\u00e9e": [
                        "Entr\u00e9es vari\u00e9es "
                    ],
                    "Plat": [
                        "Boulettes de b\u0153uf sauce piquante",
                        "Poisson bordelaise",
                        "Spaghetti",
                        "Carottes saut\u00e9es"
                    ],
                    "Dessert": [
                        "Desserts vari\u00e9s lact\u00e9s, fruits, p\u00e2tisseries"
                    ]
                },
                "CHAINE FRITERIE": "FERM\u00c9",
                "POISSON": "FERM\u00c9",
                "TOURISTE": "FERM\u00c9",
                "P.A.": "FERM\u00c9"
            },
            "D\u00eener": {
                "CHAINE TRADITIONNELLE": {
                    "Entr\u00e9e": [
                        "Entr\u00e9es vari\u00e9es"
                    ],
                    "Plat": [
                        "Pilons de poulet sauce tomate",
                        "Nuggets de poisson",
                        "PDT au gratin",
                        "Haricots verts"
                    ],
                    "Dessert": [
                        "Desserts vari\u00e9s lact\u00e9s, fruits, p\u00e2tisseries"
                    ]
                }
            }
        }
    }
}
```



## Usage

You can find the result in www.waugeard.com/API_menu_ru.php.
```html+php
<?php
	$contents = file_get_contents("https://www.waugeard.com/API_menu_ru.php"); 
        $obj = json_decode($contents, true);
        echo '<pre>' . var_export($obj["date"]["25 mars 2019"]["Déjeuner"]["CHAINE TRADITIONNELLE"], true) . '</pre>';
?>
```

 ## Author

👤 **Wilfried Augeard**
- Github: [@Exyos](https://github.com/wilfriedaugeard)
- Website: [waugeard.com](https://waugeard.com)

## License

- [MIT license](https://github.com/wilfriedaugeard/MenuRu/blob/master/LICENSE)<br/>
- Copyright © 2019 [Exyos](https://github.com/wilfriedaugeard)

