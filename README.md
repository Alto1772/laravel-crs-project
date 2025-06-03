# Course Recommendation System

Hey there! This is my pet project where I'm trying to use machine learning to help students figure out what courses they should take based on their assessment results. Fair warning though - I'm still learning as I go, so don't expect this to be production-ready. There are probably bugs lurking around, but hey, that's part of the fun!

I built the main server with Laravel 11, Livewire, and AlpineJS. For the ML magic, I'm using Python with Scikit-Learn for the actual machine learning stuff, plus Matplotlib and Seaborn to make pretty graphs. Flask handles the backend communication between everything.

## What You'll Need

- PHP 8.1 or newer
- MySQL or MariaDB (either works fine)
- Python 3.13
- A bunch of data files:
  - `colleges.json` - Check out the [example format](#collegesjson) below
  - `raw-datasets/<college>/<program>.csv` - These are just exported CSV files from Google Forms
  - `questionnaires/<college>/<program>.json` - Raw Google Form data (you can grab these with a custom Apps Script)
  - `public/assets/college/*.png` - College logo images (make 'em look nice!)

## Getting Started

First things first - let's get all the dependencies sorted out:

```sh
composer install
npm install
python3 -m venv knn-server/.venv
./knn-server/.venv/bin/pip install -r knn-server/requirements.txt 
# Windows folks, use this instead: knn-server\.venv\Scripts\pip install -r knn-server\requirements.txt 
```

### Setting Up for the First Time

Run these commands to get everything initialized:

```sh
php artisan key:generate
php artisan migrate:fresh
php artisan optimize:clear
php artisan storage:link
php artisan app:update-all-db
```

### Running in Development Mode

Want to run everything at once? Just use:

```sh
composer dev
```
This fires up both the main server and the Python KNN server together. Pretty neat, right?

### Running for Production (Way Faster!)

If you want better performance, build everything first and then run the servers separately:

```sh
npm run build
# Open two terminals and run these in each one:
php artisan serve
php artisan knn:start
```

Once everything's running, just hop over to your browser, create your first account, and you're all set!

## File Formats (The Boring but Important Stuff)

### `colleges.json`

This file tells the system about all your colleges and programs:

```json
[
    {
        "name": "CBA",
        "long_name": "College of Business and Accountacy",
        "image_url": "assets/colleges/CBA.jpg",
        "description": "This college equips their students with knowledge related to business management, finance, and entrepreneurship. It helps foster leadership and analytical skills of their students for success in the corporate world.",
        "board_programs": [
            { "name": "BSA", "long_name": "Bachelor of Science in Accountancy" },
            // ... add more programs here
        ]
    },
    // ... add more colleges here
]
```

### `raw-datasets/<college>/<program>.csv`

These are your Google Form responses exported as CSV files. They should look something like this:

```csv
"Timestamp","Total score","Question 1","Question 1 [Score]","Question 1 [Feedback]",...
"2024/12/22 11:49:31 AM GMT+8","8.00 / 10","Choice 3","1.00 / 1","",...
...
```

### `questionnaires/<college>/<program>.json`

This is the raw form structure from Google Forms:

```json
{
  "metadata": {
    // ... form metadata stuff
  },
  "items": [
    {
      "type": "MULTIPLE_CHOICE",
      "title": "Question",
      "id": 11111,
      "index": 0,
      "helpText": "",
      "isRequired": true,
      "choices": [
        {
          "value": "Choice 1",
          "isCorrect": false
        },
        {
          "value": "Choice 2",
          "isCorrect": false
        },
        {
          "value": "Choice 3",
          "isCorrect": false
        },
        {
          "value": "Choice 4",
          "isCorrect": true
        }
      ]
    },
    // ... more questions here
  ]
}
```