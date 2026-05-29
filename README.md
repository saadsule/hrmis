# Vaccine Forecasting — Setup Guide

## 1. Database Setup

Run the SQL file to create tables and import sample data:

```bash
mysql -u root -p < database/vaccine_forecasting.sql
```

Or open in phpMyAdmin and run the SQL file.

---

## 2. CodeIgniter Config

### database.php
```php
$db['default'] = array(
    'dsn'      => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => 'your_password',
    'database' => 'vaccine_forecasting',
    'dbdriver' => 'mysqli',
    ...
);
```

### config.php
```php
$config['base_url'] = 'http://localhost/vaccine_forecasting/';
```

---

## 3. File Placement

Copy these files into your existing CodeIgniter project:

```
application/
  controllers/
    Dashboard.php           ← Updated dashboard (reads from DB)
    Forecasting.php         ← New forecasting controller
  models/
    Forecasting_model.php   ← Model for both tables
  views/
    forecasting/
      index.php             ← Forecasting page view
  config/
    routes.php              ← Updated routes

database/
  vaccine_forecasting.sql   ← Tables + sample data
```

---

## 4. Navigation Link

Add to your sidebar/nav menu:

```php
<a href="<?= base_url('forecasting') ?>">
    <i class="anticon anticon-area-chart"></i>
    Forecasting Report
</a>
```

---

## 5. Tables Created

| Table | Description |
|-------|-------------|
| `vaccine_historical_data` | Historical consumption (from sample_data_sequence.csv) |
| `vaccine_forecasted_results` | LSTM forecasts (from forecasted_results_p__1_.csv) |

---

## 6. Features

- **Level filter**: Province / District / Tehsil (hardcoded options)
- **Location dropdown**: Dynamic, shows All + specific options; auto-loads tehsils via AJAX
- **Item dropdown**: Dynamic from DB
- **View toggle**: Graphical (line charts) or Tabular
- **AJAX**: All filter changes and submit load without page refresh
- **Charts**: Chart.js line charts — Blue = Historical, Red = Forecasted, same graph
- **Dynamic graphs**: One chart per location × item combination

---

## 7. Add More Data

To import the full CSV data, you can use MySQL's LOAD DATA:

```sql
USE vaccine_forecasting;

LOAD DATA LOCAL INFILE '/path/to/sample_data_sequence.csv'
INTO TABLE vaccine_historical_data
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(prov_id, prov_name, dist_id, dist_name, tehsil_id, tehsil_name,
 transaction_month, item_id, item_name, total_quantity);

LOAD DATA LOCAL INFILE '/path/to/forecasted_results_p__1_.csv'
INTO TABLE vaccine_forecasted_results
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(level_type, location, item_id, item_name, forecast_month,
 predicted_quantity, final_loss, epochs_run, lstm_units_l1, lstm_units_l2);
```
