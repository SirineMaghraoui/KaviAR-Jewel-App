using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class setLangCheckFiles : MonoBehaviour {
    public Text error;
    public Text wait;
    public Text retry;
    string error_fr = "Aucune connexion Internet trouvée.\nVérifiez votre connexion ou réessayez.";
    string error_eng = "No Internet connection found.\nCheck your connection or try again.";
    string wait_fr = "Patienter, chargement ... ";
    string wait_eng = "Please wait, downloading ...";
    string retry_fr = "REESSAYEZ ";
    string retry_eng = "RETRY ";
    // Start is called before the first frame update
    void Start () {
        if (PlayerPrefs.GetString ("language") == "fr") {
            error.text = error_fr;
            wait.text = wait_fr;
            retry.text = retry_fr;
        } else if (PlayerPrefs.GetString ("language") == "eng") {
            error.text = error_eng;
            wait.text = wait_eng;
            retry.text = retry_eng;
        }
    }
}