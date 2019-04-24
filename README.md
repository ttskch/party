# party

CLI command to calculate amounts of pizzas and drinks for a party.

## Installation

```bash
$ git clone git@github.com:ttskch/party.git
$ cd party
$ composer install
$ ln -s $(pwd)/party /usr/local/bin/party
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
