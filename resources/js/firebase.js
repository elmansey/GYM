
import { initializeApp } from 'firebase/app';
import { getDatabase , ref , set } from "firebase/database";





const firebaseConfig = {
  apiKey: "AIzaSyAqJc7NXZ3HnB6ZOm-8uoSTuxgJNYvbVSM",
  authDomain: "gym-notifecation.firebaseapp.com",
  databaseURL: "https://gym-notifecation-default-rtdb.firebaseio.com",
  projectId: "gym-notifecation",
  storageBucket: "gym-notifecation.appspot.com",
  messagingSenderId: "303987998519",
  appId: "1:303987998519:web:bdd6b53c8f0963dbc064b2",
  measurementId: "G-NR9KEVRDHK"
};



// Initialize Firebase
const app = initializeApp(firebaseConfig);
// Get a reference to the database service
export const database = getDatabase(app);


