using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
public class lightingIntensity : MonoBehaviour {
    // Start is called before the first frame update

    byte v;
    // Update is called once per frame
    void Update () {
        v = (byte) this.GetComponent<Slider> ().value;
        RenderSettings.ambientLight = new Color32 (v, v, v, 1);
    }
}