using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class selectLang : MonoBehaviour {
    string french_title = "Démarrer l'expérience";
    string english_title = "Start the experience";
    public Text title;
    public Image fr_flag;
    public Image eng_flag;

    void Start () {
        PlayerPrefs.SetString ("language", "fr");
        french ();
    }

    public void french () {
        PlayerPrefs.SetString ("language", "fr");
        title.text = french_title;
        fr_flag.GetComponent<Image> ().color = new Color (1, 1, 1, 1);
        eng_flag.GetComponent<Image> ().color = new Color (1, 1, 1, .5f);
    }
    public void english () {
        PlayerPrefs.SetString ("language", "eng");
        title.text = english_title;
        fr_flag.GetComponent<Image> ().color = new Color (1, 1, 1, .5f);
        eng_flag.GetComponent<Image> ().color = new Color (1, 1, 1, 1);
    }
}