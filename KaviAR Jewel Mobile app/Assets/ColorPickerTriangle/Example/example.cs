using System.Collections;
using UnityEngine;
using UnityEngine.SceneManagement;

public class example : MonoBehaviour {
    public GameObject instPos;

    public GameObject ColorPickedPrefab;
    public static ColorPickerTriangle CP;
    private GameObject go;

    public static bool ok = false;
    public static bool des = false;
    public GameObject sprite;
    void Update () {
        if (des) {
            Destroy (go);
            des = false;
        }
        if (ok) {
            StartPaint ();
            ok = false;
        }

    }

    private void StartPaint () {
        go = (GameObject) Instantiate (ColorPickedPrefab, instPos.transform.position, Quaternion.identity);
        go.transform.LookAt (Camera.main.transform);
        CP = go.GetComponent<ColorPickerTriangle> ();
        CP.SetNewColor (Color.white);
        if (SceneManager.GetActiveScene ().name == "Rings") {
            ringsManager.paletteActivated = true;
        } else if (SceneManager.GetActiveScene ().name == "Watches") {
            watchesManager.paletteActivated = true;
        } else if (SceneManager.GetActiveScene ().name == "PreviewWatch") {
            previewWatch.paletteActivated = true;
        } else if (SceneManager.GetActiveScene ().name == "PreviewRing") {
            previewRing.paletteActivated = true;
        }
    }
}