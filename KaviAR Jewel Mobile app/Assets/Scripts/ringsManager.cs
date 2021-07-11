using System.Collections;
using System.Collections.Generic;
using System.IO;
using UnityEngine;
using UnityEngine.SceneManagement;
using UnityEngine.UI;

public class ringsManager : MonoBehaviour {
    public GameObject instPos;
    public List<GameObject> rings;
    public Material goldMat;
    public Material silverMat;
    public Material pinkMat;
    GameObject currentRing;
    GameObject[] metalParts;
    GameObject[] gemParts;
    public GameObject palette;
    public Text colorText;
    public GameObject ar;
    public GameObject closePalette;
    public static bool paletteActivated;
    int colorNumber;
    string defaultModelsFolder = "/Default_projects";

    // Start is called before the first frame update
    void Start () {
        data.metalColorRing = "silver";
        data.displayed = 0;
        data.url = "";
        showRing ();
    }

    // Update is called once per frame
    void Update () {
        if (paletteActivated) {
            for (int i = 0; i < gemParts.Length; i++) {
                if (gemParts[i] != null) {
                    gemParts[i].GetComponent<Renderer> ().material.color = example.CP.TheColor;
                }
            }
        }
    }

    void showRing () {
        AssetBundle localAssetBundle = AssetBundle.LoadFromFile (Path.Combine (Application.persistentDataPath + defaultModelsFolder, "ring"));
        GameObject prefab = localAssetBundle.LoadAsset<GameObject> ("ring" + (data.displayed + 1).ToString ());
        currentRing = Instantiate (prefab, instPos.transform.position, instPos.transform.rotation);
        localAssetBundle.Unload (false);

        currentRing.transform.parent = instPos.transform;

        if (currentRing.tag == "color") {
            palette.GetComponent<Button> ().interactable = true;
            colorText.GetComponent<Text> ().color = new Color (1, 1, 1, 1);
            gemParts = GameObject.FindGameObjectsWithTag ("gem");

        } else {
            palette.GetComponent<Button> ().interactable = false;
            colorText.GetComponent<Text> ().color = new Color (1, 1, 1, .5f);
            closePalette.SetActive (false);
        }
        metalParts = GameObject.FindGameObjectsWithTag ("metal");

        if (data.metalColorRing == "silver") {
            selectSilver ();
        } else if (data.metalColorRing == "gold") {
            selectGold ();
        } else if (data.metalColorRing == "pink") {
            selectPink ();
        }

    }
    public void next () {
        instPos.transform.rotation = Quaternion.Euler (0, 35, 0);
        if (currentRing.tag == "color") {
            paletteActivated = false;
            for (int i = 0; i < gemParts.Length; i++) {
                if (gemParts[i] != null) {
                    gemParts[i].GetComponent<Renderer> ().material.color = Color.white;
                }
            }
        }
        palette.GetComponent<Button> ().interactable = false;
        colorText.GetComponent<Text> ().color = new Color (1, 1, 1, .5f);
        example.des = true;
        metalParts = null;
        gemParts = null;
        ar.SetActive (true);
        closePalette.SetActive (false);
        Destroy (currentRing);
        if (data.displayed == rings.Count - 1) {
            data.displayed = 0;
        } else {
            data.displayed++;
        }
        showRing ();
    }
    public void previous () {
        instPos.transform.rotation = Quaternion.Euler (0, 35, 0);
        if (currentRing.tag == "color") {
            paletteActivated = false;
            for (int i = 0; i < gemParts.Length; i++) {
                if (gemParts[i] != null) {
                    gemParts[i].GetComponent<Renderer> ().material.color = Color.white;
                }
            }
        }
        palette.GetComponent<Button> ().interactable = false;
        colorText.GetComponent<Text> ().color = new Color (1, 1, 1, .5f);
        closePalette.SetActive (false);
        example.des = true;
        metalParts = null;
        gemParts = null;
        ar.SetActive (true);
        Destroy (currentRing);
        if (data.displayed == 0) {
            data.displayed = rings.Count - 1;
        } else {
            data.displayed--;
        }
        showRing ();
    }
    public void selectGold () {
        data.metalColorRing = "gold";
        colorNumber = 2;
        for (int i = 0; i < metalParts.Length; i++) {
            if (metalParts[i] != null)
                metalParts[i].GetComponent<Renderer> ().material = goldMat;
        }
    }
    public void selectSilver () {
        data.metalColorRing = "silver";
        colorNumber = 1;
        for (int i = 0; i < metalParts.Length; i++) {
            if (metalParts[i] != null)
                metalParts[i].GetComponent<Renderer> ().material = silverMat;
        }
    }
    public void selectPink () {
        data.metalColorRing = "pink";
        colorNumber = 3;
        for (int i = 0; i < metalParts.Length; i++) {
            if (metalParts[i] != null)
                metalParts[i].GetComponent<Renderer> ().material = pinkMat;
        }
    }

    public void showPalette () {
        if (currentRing.tag == "color") {
            GameObject go = GameObject.FindGameObjectWithTag ("picker");
            if (go != null) {
                paletteActivated = false;
                data.gemColor = example.CP.TheColor;
                example.des = true;
                ar.SetActive (true);
                closePalette.SetActive (false);
            } else {
                example.ok = true;
                ar.SetActive (false);
                closePalette.SetActive (true);
            }
        }
    }
    public void hidePalette () {
        data.gemColor = example.CP.TheColor;
        example.des = true;
        closePalette.SetActive (false);
        ar.SetActive (true);
    }
    public void tryon () {
        data.url = "http://jewel.kaviar.app/?type=ring&color=" + colorNumber.ToString () + "&object=model" + data.displayed.ToString ();
        SceneManager.LoadScene ("TryOnRing", LoadSceneMode.Single);
    }
}