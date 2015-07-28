import webbrowser
import time

file = open("imagedata.txt") #opens the list of all the photos of the animals

for line in file: #iterates through the file
    if line[0] == "(": #checks if the line is a picture.  In the file, the picture lines start with ( and other lines we don't want, are text only, so this lets us filter them
        line = line.split(",") #this splits the line into a list so we can extract the information (the web address) that we need
        x = line[4] #the URL part is the 5th part of the line, so this gets us that
        x = x.rstrip(")")
        x = x.strip() #we format the line so that we can use it in an actual web address
        y = "www.edgeofexistence.org" + x #we add the URL to the original address
        webbrowser.open(y) #we check the picture to see if it's good
        print("Type 'y' to save the picture, press anything else to continue")
        answer = input()
        if answer.upper() == "Y":
            file2 = open("savedPictures.txt","a")
            file2.write(str(line))
            print("What animal is in the picture?")
            file2.write(input())
            file2.close() #adds the saved picture, the one we want to use, to a separate file for us to use later

                
            
        
