using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class SetLangCheckUpdates : MonoBehaviour {
    public Text error;
    public Text wait;
    public Text retry;
    public Text offline;
    string error_fr = "Aucune connexion Internet trouvée.\nVérifiez votre connexion ou réessayez.";
    string error_eng = "No Internet connection found.\nCheck your connection or try again.";
    string wait_fr = "Vérification des MAJs ... ";
    string wait_eng = "Checking updates ...";
    string retry_fr = "REESSAYEZ ";
    string retry_eng = "RETRY ";
    string offline_fr = "MODE\nHORS LIGNE ";
    string offline_eng = "OFFLINE\nMODE ";
    // Start is called before the first frame update
    void Start () {
        if (PlayerPrefs.GetString ("language") == "fr") {
            error.text = error_fr;
            wait.text = wait_fr;
            retry.text = retry_fr;
            offline.text = offline_fr;
        } else if (PlayerPrefs.GetString ("language") == "eng") {
            error.text = error_eng;
            wait.text = wait_eng;
            retry.text = retry_eng;
            offline.text = offline_eng;
        }
    }

}