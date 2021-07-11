using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
public class setLangTuto : MonoBehaviour {
    public Text tip;
    public Text tryon;
    string tip_fr = "La main doit être orthogonale\nà la caméra";
    string tip_eng = "Hand should be orthogonal\nto the camera";
    string tryon_fr = "Try it";
    string tryon_eng = "Essayer";
    void Start () {
        if (PlayerPrefs.GetString ("language") == "fr") {
            tip.text = tip_fr;
            tryon.text = tryon_fr;
        } else if (PlayerPrefs.GetString ("language") == "eng") {
            tip.text = tip_eng;
            tryon.text = tryon_eng;
        }
    }
}