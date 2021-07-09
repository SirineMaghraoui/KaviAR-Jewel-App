# KaviAR-Jewel-App 

For my graduation project in my Software Engineering studies, I have developed a AR app and a Web app for AR Jewelry Try-On. This project has the following features:
- The user must create an account on the web app to access to the different features. 
- The user has their own dashboard that helps them manage their jewelry projects, upload their own model and test it on the app once it's approved, modify their profile and contact the support team through the app. 
- The administrators also uses the web app through their specific dashboard. 
- They manage all users and emails sent by users. The administrators review the projects requests made by users and approve or decline them. They can also act as a regular user.
- The mobile app uses AI and deep learning to place jewelry (rings and watches) on the user hand. 
- The mobiles app and the web app communicate through web services to exchange data. Once the user logs in, the app displays their approved projects list. 
- The user chooses a project, visualizes the 3D model, modify its materials and colors and try it on virtually. One the camera detects the human hand, and a pictures is taken or uploaded for the processing phase, the app runs the picture on the DNN model trained using the OpenCV and OpenPose libraries, and extracts 21 key points that represent the hand joints and places the jewel model on the right location. 
- Once the AR experience is successful, the user can share a screenshot on their AR experience on social media or save it on their device.

# Tools I used:
- Unity 3D
- C#
- Adobe Illustrator
- OpenCV
- OpenPose
- CodeIgniter
- PHP7/HTML5/CSS3/Bootstrap

