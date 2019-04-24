# party

[![Build Status](https://travis-ci.com/ttskch/party.svg?branch=master)](https://travis-ci.com/ttskch/party)

CLI command to calculate amounts of pizzas and drinks for a party.

## Installation

```bash
$ git clone git@github.com:ttskch/party.git
$ cd party
$ composer install
$ ln -s $(pwd)/bin/party /usr/local/bin/party
```

## Usage

```bash
$ party
How many people? : 15
How much is budget per person? : 2000
+-------------------------------+-----+-------+
| What you have to buy          | Num | Price |
+-------------------------------+-----+-------+
| Pizza (L)                     | 8   | 24000 |
| Cans of beer                  | 16  | 3680  |
| Cans of other alcohol         | 8   | 1600  |
| Bottles of non-alcohol (1.5L) | 2   | 400   |
+-------------------------------+-----+-------+
| Total                         | -   | 29680 |
| Average                       | -   | 1979  |
+-------------------------------+-----+-------+
+--------------------+-----+
| Amounts per person | Num |
+--------------------+-----+
| Pizza (pieces)     | 4.3 |
| Drink (cans/cups)  | 2.2 |
+--------------------+-----+
```

### Configure

```bash
$ party config
[SUCCESS] "/path/to/home/.config/party/config.yaml" is created. Modify it if you need.
$ vi ~/.config/party/config.yaml
```

and tailor it to your needs. 

```yaml
version: 1.0.0

# how people drink beer, other alcohol and non alcohol are distributed (total number is meaningless)
distribution_rates:
  beer: 10
  other_alcohol: 5
  non_alcohol: 5

# how many cups 1 bottle of non alcohol can be divided to
cups_for_one_non_alcohol: 4.3 # 1500 / 350 = 4.2857...

# how many pieces of L size pizza for 1 can/cup of drink
pizza_pieces_for_one_drink: 2.5

# JPY and MXN are supported (please add your currency to https://github.com/ttskch/party)
currency: JPY
```
