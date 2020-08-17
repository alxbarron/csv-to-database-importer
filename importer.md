# CVS Importer

## Health check

Used to check the app

**URL** : `/contact-importer/`

**Method** : `GET`

**Auth required** : NO

### Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "success": true,
    "status":  "OK",
    "data_test: []
}
```

## Upload CSV file

Used to upload the CSV file & also to retrieve the name of the file created on serverside along with headers and sample data.

**URL** : `/contact-importer/`

**Method** : `POST`

**Auth required** : NO

**Data constraints**

```json
{
    "csv-file": "[valid CSV file]",
}
```

**Data example**

```json
{
    "csv-file": "contact_list_sample.csv"
}
```

### Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "success": true,
    "data": {
        "fields": [...],
        "content_sample": [...],
        "csv_file": "csv-imports/1597682501.csv"
    },
    "message": "CSV file Uploaded successfully"
}
```

### Error Response

**Condition** : If a non CSV file is passed or out the range between 1k - 200k.

**Code** : `400 BAD REQUEST`

**Content** :

```json
{
    "success": false,
    "message": "The given data was invalid."
}
```

## Import mapped records into database

Import the records after map the fields from database against CSV file header columns.

**URL** : `/contact-importer/`

**Method** : `PUT`

**Auth required** : NO

**Data constraints**

```json
{
    "csv_file": "File route from POST the file",
    "csv_field[0]": "Database field name associated with CSV index",
    "custom_attr[1]": "CSV header name associated with CSV index",
}
```

**Data example**

```json
{
    "csv_file": "csv-imports/1597550925.csv",
    "csv_field[0]": "team_id",
    "csv_field[1]": "name",
    "csv_field[3]": "phone",
    "csv_field[2]": "email",
    "csv_field[4]": "sticky_phone_number_id",
    "custom_attr[5]": "street",
    "custom_attr[6]": "city",
    "custom_attr[7]": "state",
}
```

### Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "success": true
}
```

## Error Response

**Condition** : If a non CSV file is passed or out the range between 1k - 200k.

**Code** : `400 BAD REQUEST`

**Content** :

```json
{
    "success": false,
    "message": "The given data was invalid."
}
```