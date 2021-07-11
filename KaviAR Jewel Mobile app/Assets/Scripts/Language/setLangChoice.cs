using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
public class setLangChoice : MonoBehaviour {

    public Text selection;
    string selection_fr = "Sélectionnez un accessoire ";
    string selection_eng = "Select accessory";
    void Start () {
        if (PlayerPrefs.GetString ("language") == "fr") {
            selection.text = selection_fr;
        } else if (PlayerPrefs.GetString ("language") == "eng") {
            selection.text = selection_eng;
        }
    }

}