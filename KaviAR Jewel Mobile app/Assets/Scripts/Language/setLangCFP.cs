using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
public class setLangCFP : MonoBehaviour {
    public Text processing;
    public Text movePhone;
    public Text errorPhone;
    public Text waitingMsg;
    public GameObject i_fr;
    public GameObject i_eng;
    string processing_fr = "Traitement ...";
    string processing_eng = "Processing ...";
    string movePhone_fr = "Placez votre main au centre \net prenez la en photo";
    string movePhone_eng = "Center your hand\nand take a picture";
    string errorPhone_fr = "Ré-essayez, touchez\npour afficher l’aide";
    string errorPhone_eng = "Try again, touch\nto display help";
    string waitingMsg_fr = "Patientez... Nous simulons le rendu";
    string waitingMsg_eng = "Wait... We are rendering the simulation";
    // Start is called before the first frame update
    void Start () {
        if (PlayerPrefs.GetString ("language") == "fr") {
            processing.text = processing_fr;
            movePhone.text = movePhone_fr;
            errorPhone.text = errorPhone_fr;
            waitingMsg.text = waitingMsg_fr;
            i_fr.SetActive (true);
            i_eng.SetActive (false);
        } else if (PlayerPrefs.GetString ("language") == "eng") {
            processing.text = processing_eng;
            movePhone.text = movePhone_eng;
            errorPhone.text = errorPhone_eng;
            waitingMsg.text = waitingMsg_eng;
            i_eng.SetActive (true);
            i_fr.SetActive (false);
        }
    }
}