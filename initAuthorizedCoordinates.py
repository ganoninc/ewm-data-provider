# First this script downloads Emoji Weather Map from Github
# Then it parses the templates and creates an array of authorized coordinates for this proxy
# Eventually it writes the result as a json file and clean the workplace

import git
import os
import shutil
import json

def getEmojiWeatherMap():
    if os.path.isdir("./emojis-weather-map"):
        shutil.rmtree("./emojis-weather-map")
    git.Git("./").clone("https://github.com/ganoninc/emojis-weather-map.git")


def getAutorizedCoordinatesFromTemplateData(templateData):
    autorizedCoordinates = []
    for row in templateData["rows"]:
        for item in row["items"]:
            if item["type"] == "emoji":
                autorizedCoordinates.append(item["geographicCoordinates"])
    return autorizedCoordinates


def getAutorizedCoordinates():
    autorizedCoordinates = []
    for template in os.listdir("./emojis-weather-map/public/templates"):
        with open("./emojis-weather-map/public/templates/"+template) as jsonFile:
            data = json.load(jsonFile)
            autorizedCoordinates += getAutorizedCoordinatesFromTemplateData(data)
    return autorizedCoordinates


def exportAutorizedCoordinatesAsJson(autorizedCoordinates):
    keysOfAutorizedCoordinates = []
    for autorizedCoordinatesElt in autorizedCoordinates:
        keysOfAutorizedCoordinates.append(
            str(autorizedCoordinatesElt["latitude"]) + str(autorizedCoordinatesElt["longitude"]))
    with open("./autorizedCoordinates.json", "w") as output:
        json.dump(keysOfAutorizedCoordinates, output)


def cleanWorkspace():
    if os.path.isdir("./emojis-weather-map"):
        shutil.rmtree("./emojis-weather-map")


def main():
    getEmojiWeatherMap()
    if not os.path.isdir("./emojis-weather-map"):
        print "There was an error while cloning Emoji Weather Map. Please check your internet connexion or try again later."
    else:
        autorizedCoordinates = getAutorizedCoordinates()
        exportAutorizedCoordinatesAsJson(autorizedCoordinates)
    cleanWorkspace()

if __name__ == "__main__":
  main()
