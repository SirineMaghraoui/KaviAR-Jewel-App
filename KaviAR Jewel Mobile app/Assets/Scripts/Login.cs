using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using Button = UnityEngine.UI.Button;

public class Login : MonoBehaviour {
    public InputField username;
    public InputField password;
    public Button LoginButton;
    public Text error_msg;
    public Toggle my_toggle;
    // Start is called before the first frame update
    void Start () {
        PlayerPrefs.SetString ("logged", "false");
        LoginButton.onClick.AddListener (() => {
            StartCoroutine (main.instance.web.Login (username.text, password.text));
        });
    }

    public void toggle_changed (bool newValue) {
        if (newValue) {
            PlayerPrefs.SetString ("logged", "true");
        } else {
            PlayerPrefs.SetString ("logged", "false");
        }
        Debug.Log (PlayerPrefs.GetString ("logged"));
    }
}