using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class SetLangLogin : MonoBehaviour {
    public Text username;
    public Text password;
    public Text logged;
    public Text login_button;
    public Text no_account;
    public Text button_signup;
    string username_fr = "Entrez votre username";
    string password_fr = "Entrez votre password";
    string logged_fr = "Rester connecté";
    string login_button_fr = "Se connecter";
    string no_account_fr = "Vous n'avez pas de compte?";
    string button_signup_fr = "S'inscrire";
    string username_eng = "Enter your username";
    string password_eng = "Enter your password";
    string logged_eng = "Stay logged in";
    string login_button_eng = "Login";
    string no_account_eng = "You don't have an account?";
    string button_signup_eng = "Sign up";

    // Start is called before the first frame update
    void Start () {
        if (PlayerPrefs.GetString ("language") == "fr") {
            username.text = username_fr;
            password.text = password_fr;
            logged.text = logged_fr;
            login_button.text = login_button_fr;
            no_account.text = no_account_fr;
            button_signup.text = button_signup_fr;
        } else if (PlayerPrefs.GetString ("language") == "eng") {
            username.text = username_eng;
            password.text = password_eng;
            logged.text = logged_eng;
            login_button.text = login_button_eng;
            no_account.text = no_account_eng;
            button_signup.text = button_signup_eng;
        }
    }

}