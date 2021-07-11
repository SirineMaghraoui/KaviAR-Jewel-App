using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
public class setLangWacthes : MonoBehaviour {
    public Text selection;
    public Text gemColor;
    public Text tryOn;
    string selection_fr = "Sélectionnez un modèle";
    string selection_eng = "Select a model";
    string gemColor_fr = "Couleur";
    string gemColor_eng = "Color";
    string tryOn_fr = "Essayer";
    string tryOn_eng = "Try it";
    void Start () {
        if (PlayerPrefs.GetString ("language") == "fr") {
            selection.text = selection_fr;
            gemColor.text = gemColor_fr;
            tryOn.text = tryOn_fr;
        } else if (PlayerPrefs.GetString ("language") == "eng") {
            selection.text = selection_eng;
            gemColor.text = gemColor_eng;
            tryOn.text = tryOn_eng;
        }
    }
}