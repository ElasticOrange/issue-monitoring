#!/bin/bash
if [ -z "$TRAVIS_BRANCH" ]
    then
        TRAVIS_BRANCH="$(git symbolic-ref -q --short HEAD)"
fi

if [ $TRAVIS_BRANCH == 'master' ]
    then
        echo "Deploying live"
        envoy run deploy --on=live --branch=master --folder=issuemonitoring
        # curl -X POST --data-urlencode 'payload={"channel": "#deployment-tracking", "username": "Deploy Truck", "text": "Updated http://staging.lendia.ro", "icon_emoji": ":deploytruck:"}' https://hooks.slack.com/services/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
fi

if [ $TRAVIS_BRANCH == 'staging' ]
    then
        echo "Deploying staging"
        envoy run deploy --on=staging --branch=staging --folder=issuemonitoring
        # curl -X POST --data-urlencode 'payload={"channel": "#deployment-tracking", "username": "Deploy Truck", "text": "Updated https://lendia.ro", "icon_emoji": ":deploytruck:"}' https://hooks.slack.com/services/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
fi
