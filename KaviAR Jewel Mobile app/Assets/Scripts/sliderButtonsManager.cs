using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class sliderButtonsManager : MonoBehaviour {
    public bool state = false;
    public GameObject scaleB;
    public GameObject translateB;
    public GameObject rotateB;
    public GameObject lightingB;
    public GameObject slider;
    Animator anim;
    public GameObject translateUp;
    public GameObject translateDown;
    public GameObject translateRight;
    public GameObject translateLeft;
    public GameObject rotateRight;
    public GameObject rotateLeft;
    public GameObject scaleUp;
    public GameObject scaleDown;
    public GameObject lightUp;
    public GameObject lightDown;
    public GameObject slider_light;
    void Start () {
        anim = slider.GetComponent<Animator> ();
    }

    public void hideShow () {
        if (!state) {
            anim.SetInteger ("ok", 1);
            scaleB.GetComponent<Image> ().color = new Color (1, 1, 1, .5f);
            rotateB.GetComponent<Image> ().color = new Color (1, 1, 1, .5f);
            translateB.GetComponent<Image> ().color = new Color (1, 1, 1, .5f);
            lightingB.GetComponent<Image> ().color = new Color (1, 1, 1, .5f);

            state = true;
        } else {
            translateUp.SetActive (false);
            translateDown.SetActive (false);
            translateRight.SetActive (false);
            translateLeft.SetActive (false);
            rotateRight.SetActive (false);
            rotateLeft.SetActive (false);
            scaleUp.SetActive (false);
            scaleDown.SetActive (false);
            lightUp.SetActive (false);
            lightDown.SetActive (false);
            slider_light.SetActive (false);
            anim.SetInteger ("ok", 2);
            state = false;
        }
    }

    public void scale () {
        scaleB.GetComponent<Image> ().color = new Color (1, 1, 1, 1);
        rotateB.GetComponent<Image> ().color = new Color (0, 0, 0, .5f);
        translateB.GetComponent<Image> ().color = new Color (0, 0, 0, .5f);
        lightingB.GetComponent<Image> ().color = new Color (0, 0, 0, .5f);
    }
    public void rotate () {
        scaleB.GetComponent<Image> ().color = new Color (0, 0, 0, .5f);
        rotateB.GetComponent<Image> ().color = new Color (1, 1, 1, 1);
        translateB.GetComponent<Image> ().color = new Color (0, 0, 0, .5f);
        lightingB.GetComponent<Image> ().color = new Color (0, 0, 0, .5f);
    }
    public void translate () {
        scaleB.GetComponent<Image> ().color = new Color (0, 0, 0, .5f);
        rotateB.GetComponent<Image> ().color = new Color (0, 0, 0, .5f);
        translateB.GetComponent<Image> ().color = new Color (1, 1, 1, 1);
        lightingB.GetComponent<Image> ().color = new Color (0, 0, 0, .5f);
    }
    public void light () {
        scaleB.GetComponent<Image> ().color = new Color (0, 0, 0, .5f);
        rotateB.GetComponent<Image> ().color = new Color (0, 0, 0, .5f);
        translateB.GetComponent<Image> ().color = new Color (0, 0, 0, .5f);
        lightingB.GetComponent<Image> ().color = new Color (1, 1, 1, 1);
    }
}