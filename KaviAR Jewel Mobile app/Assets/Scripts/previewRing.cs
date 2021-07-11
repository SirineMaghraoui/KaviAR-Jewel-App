using System.Collections;
using System.Collections.Generic;
using System.IO;
using UnityEngine;
using UnityEngine.SceneManagement;
using UnityEngine.UI;

public class previewRing : MonoBehaviour {
    public GameObject instPos;
    public List<GameObject> rings;
    public Material goldMat;
    public Material silverMat;
    public Material pinkMat;
    public Material gem;
    public Material sidegemMat;
    GameObject currentRing;
    public GameObject[] metalParts;
    public GameObject[] gemParts;
    public GameObject[] maingem_sidegem;
    public GameObject palette;
    public Text colorText;
    public GameObject ar;
    public GameObject closePalette;
    public static bool paletteActivated;
    int colorNumber;
    GameObject prefab;
    string directoryName1 = "/My_projects";
    string directoryName2 = "/Public_projects";
    AssetBundle localAssetBundle;
    // Start is called before the first frame update
    void Start () {
        data.metalColorRing = "silver";
        data.gemColor = Color.white;
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
        if (data.selected_personal_project != "" && data.selected_public_project == "") {
            localAssetBundle = AssetBundle.LoadFromFile (Path.Combine (Application.persistentDataPath + directoryName1, data.selected_personal_project + "_AB"));
        } else if (data.selected_personal_project == "" && data.selected_public_project != "") {
            localAssetBundle = AssetBundle.LoadFromFile (Path.Combine (Application.persistentDataPath + directoryName2, data.selected_public_project + "_AB"));
        }
        prefab = localAssetBundle.LoadAsset<GameObject> ("ring");
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
        } else
        if (data.metalColorRing == "gold") {
            selectGold ();
        } else if (data.metalColorRing == "pink") {
            selectPink ();
        }
        for (int i = 0; i < gemParts.Length; i++) {
            if (gemParts[i] != null) {
                gemParts[i].GetComponent<Renderer> ().material = gem;
                gemParts[i].GetComponent<Renderer> ().material.color = data.gemColor;
            }
        }
        maingem_sidegem = GameObject.FindObjectsOfType<GameObject> ();
        foreach (GameObject gameObj in maingem_sidegem) {
            if (gameObj.name == "sidegems") {
                gameObj.GetComponent<Renderer> ().material = sidegemMat;
            } else if (gameObj.name == "maingem") {
                gameObj.GetComponent<Renderer> ().material = gem;
            }
        }

        if (currentRing.tag == "color") {
            paletteActivated = true;
            paletteActivated = false;
        }

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
        SceneManager.LoadScene ("TryOnRing", LoadSceneMode.Single);
    }
}