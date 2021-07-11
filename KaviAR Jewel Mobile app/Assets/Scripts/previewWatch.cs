using System.Collections;
using System.Collections.Generic;
using System.IO;
using UnityEngine;
using UnityEngine.SceneManagement;

public class previewWatch : MonoBehaviour {
    public GameObject instPos;
    public List<GameObject> watches;
    public Material goldMat;
    public Material silverMat;
    public Material blackMat;
    public Material leatherMat;
    public Material digitalMat;

    GameObject currentWatch;
    GameObject[] metalParts;
    GameObject[] beltParts;
    GameObject[] reverseParts;
    public GameObject palette;
    public GameObject ar;
    public GameObject closePalette;
    public static bool paletteActivated;
    public GameObject g;
    public GameObject s;
    public GameObject b;
    public GameObject go;
    public static bool startColoring = false;
    int colorNumber;
    string directoryName1 = "/My_projects";
    string directoryName2 = "/Public_projects";
    AssetBundle localAssetBundle;
    // Start is called before the first frame update
    void Start () {
        data.metalColorWatch = "silver";
        data.beltColor = leatherMat.color;
        data.url = "";
        showRing ();
        Debug.Log (data.beltColor);
    }

    // Update is called once per frame
    void Update () {
        go = GameObject.FindGameObjectWithTag ("picker");
        if (paletteActivated) {
            if (startColoring) {
                if (currentWatch.tag == "color") {
                    for (int i = 0; i < beltParts.Length; i++) {
                        if (beltParts[i] != null) {
                            beltParts[i].GetComponent<Renderer> ().material.color = example.CP.TheColor;
                            if (data.changedB != true) {
                                data.changedB = true;
                            }
                        }
                    }
                } else if (currentWatch.tag == "plastic") {
                    currentWatch.transform.Find ("Hand_watch").GetComponent<Renderer> ().materials[2].color = example.CP.TheColor;
                    if (data.changedP != true) {
                        data.changedP = true;
                    }
                }
            }
        }
    }
    void rescaleRing (int percent) {
        float x = (currentWatch.transform.localScale.x * percent) / 100;
        float y = (currentWatch.transform.localScale.y * percent) / 100;
        float z = (currentWatch.transform.localScale.z * percent) / 100;
        currentWatch.transform.localScale = new Vector3 (x, y, z);
    }
    void showRing () {

        if (data.selected_personal_project != "" && data.selected_public_project == "") {
            localAssetBundle = AssetBundle.LoadFromFile (Path.Combine (Application.persistentDataPath + directoryName1, data.selected_personal_project + "_AB"));
        } else if (data.selected_personal_project == "" && data.selected_public_project != "") {
            localAssetBundle = AssetBundle.LoadFromFile (Path.Combine (Application.persistentDataPath + directoryName2, data.selected_public_project + "_AB"));
        }

        GameObject prefab = localAssetBundle.LoadAsset<GameObject> ("watch");
        currentWatch = Instantiate (prefab, instPos.transform.position, instPos.transform.rotation);
        localAssetBundle.Unload (false);
        currentWatch.transform.parent = instPos.transform;

        rescaleRing (75);
        if (currentWatch.tag == "color" || currentWatch.tag == "plastic") {
            if (currentWatch.tag == "plastic") {
                GameObject plane = currentWatch.transform.Find ("Plane").gameObject;
                plane.GetComponent<Renderer> ().material = digitalMat;
            }
            palette.SetActive (true);
            beltParts = GameObject.FindGameObjectsWithTag ("belt");
            for (int i = 0; i < beltParts.Length; i++) {
                if (beltParts[i] != null) {
                    beltParts[i].GetComponent<Renderer> ().material = leatherMat;
                }
            }
            g.SetActive (false);
            s.SetActive (false);
            b.SetActive (false);
        } else {
            palette.SetActive (false);
            closePalette.SetActive (false);
            g.SetActive (true);
            s.SetActive (true);
            b.SetActive (true);
        }
        metalParts = GameObject.FindGameObjectsWithTag ("metal");
        reverseParts = GameObject.FindGameObjectsWithTag ("reverse");

        if (data.metalColorWatch == "silver") {
            selectSilver ();
        } else if (data.metalColorWatch == "gold") {
            selectGold ();
        } else if (data.metalColorWatch == "black") {
            selectBlack ();
        }
    }

    public void selectGold () {
        colorNumber = 1;
        data.metalColorWatch = "gold";
        for (int i = 0; i < metalParts.Length; i++) {
            if (metalParts[i] != null) {
                if (metalParts[i].GetComponent<Renderer> ().materials.Length == 1) {
                    metalParts[i].GetComponent<Renderer> ().material = goldMat;
                } else if (metalParts[i].GetComponent<Renderer> ().materials.Length == 2) {
                    Material[] mat = metalParts[i].GetComponent<Renderer> ().materials;
                    mat[0] = goldMat;
                    mat[1] = goldMat;
                    metalParts[i].GetComponent<Renderer> ().materials = mat;
                }
            }
        }

        for (int i = 0; i < reverseParts.Length; i++) {
            if (reverseParts[i] != null) {
                if (reverseParts[i].GetComponent<Renderer> ().materials.Length == 1) {
                    reverseParts[i].GetComponent<Renderer> ().material = silverMat;
                } else if (reverseParts[i].GetComponent<Renderer> ().materials.Length == 2) {
                    Material[] mat = reverseParts[i].GetComponent<Renderer> ().materials;
                    mat[0] = silverMat;
                    mat[1] = silverMat;
                    reverseParts[i].GetComponent<Renderer> ().materials = mat;
                }
            }
        }
    }

    public void selectSilver () {
        data.metalColorWatch = "silver";
        colorNumber = 2;
        for (int i = 0; i < metalParts.Length; i++) {
            if (metalParts[i] != null) {
                if (metalParts[i].GetComponent<Renderer> ().materials.Length == 1) {
                    metalParts[i].GetComponent<Renderer> ().material = silverMat;
                } else if (metalParts[i].GetComponent<Renderer> ().materials.Length == 2) {
                    Material[] mat = metalParts[i].GetComponent<Renderer> ().materials;
                    mat[0] = silverMat;
                    mat[1] = silverMat;
                    metalParts[i].GetComponent<Renderer> ().materials = mat;
                }
            }
        }

        for (int i = 0; i < reverseParts.Length; i++) {
            if (reverseParts[i] != null) {
                if (reverseParts[i].GetComponent<Renderer> ().materials.Length == 1) {
                    reverseParts[i].GetComponent<Renderer> ().material = goldMat;
                } else if (reverseParts[i].GetComponent<Renderer> ().materials.Length == 2) {
                    Material[] mat = reverseParts[i].GetComponent<Renderer> ().materials;
                    mat[0] = goldMat;
                    mat[1] = goldMat;
                    reverseParts[i].GetComponent<Renderer> ().materials = mat;
                }
            }
        }
    }
    public void selectBlack () {
        data.metalColorWatch = "black";
        colorNumber = 3;
        for (int i = 0; i < metalParts.Length; i++) {
            if (metalParts[i] != null) {
                if (metalParts[i].GetComponent<Renderer> ().materials.Length == 1) {
                    metalParts[i].GetComponent<Renderer> ().material = blackMat;
                } else if (metalParts[i].GetComponent<Renderer> ().materials.Length == 2) {
                    Material[] mat = metalParts[i].GetComponent<Renderer> ().materials;
                    mat[0] = blackMat;
                    mat[1] = blackMat;
                    metalParts[i].GetComponent<Renderer> ().materials = mat;
                }
            }
        }

        for (int i = 0; i < reverseParts.Length; i++) {
            if (reverseParts[i] != null) {
                if (reverseParts[i].GetComponent<Renderer> ().materials.Length == 1) {
                    reverseParts[i].GetComponent<Renderer> ().material = silverMat;
                } else if (reverseParts[i].GetComponent<Renderer> ().materials.Length == 2) {
                    Material[] mat = reverseParts[i].GetComponent<Renderer> ().materials;
                    mat[0] = silverMat;
                    mat[1] = silverMat;
                    reverseParts[i].GetComponent<Renderer> ().materials = mat;
                }
            }
        }
    }

    public void showPalette () {

        if (go != null) {
            paletteActivated = true;
            startColoring = true;
            data.beltColor = example.CP.TheColor;
            example.des = true;
            ar.SetActive (true);
            closePalette.SetActive (false);
        } else {
            example.ok = true;
            ar.SetActive (false);
            closePalette.SetActive (true);
        }
    }
    public void hidePalette () {
        paletteActivated = false;
        previewWatch.startColoring = false;
        data.beltColor = example.CP.TheColor;
        example.des = true;
        closePalette.SetActive (false);
        ar.SetActive (true);
    }
    public void tryon () {
        SceneManager.LoadScene ("TryOnWatch", LoadSceneMode.Single);
    }
}