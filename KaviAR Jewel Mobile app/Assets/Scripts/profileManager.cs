using System.Collections;
using System.Collections.Generic;
using System.IO;
using UnityEngine;
using UnityEngine.Networking;
using UnityEngine.UI;

public class profileManager : MonoBehaviour {
    [SerializeField]
    Image myimage = null;
    string directoryName = "/Safe_Files";
    public Image user_picture;
    public Text username;
    userInfo UserInfo_data = new userInfo ();
    // Start is called before the first frame update
    void Start () {
        UserInfo_data = saveSystem.loadUserInfo ();
        if (PlayerPrefs.GetString ("language") == "fr") {
            username.text = "Bienvenue\n" + UserInfo_data.username;
        } else if (PlayerPrefs.GetString ("language") == "eng") {
            username.text = "Hi\n" + UserInfo_data.username;
        }

        if (UserInfo_data.picture_path != "") {
            string fileName = Path.GetFileName (UserInfo_data.picture_path);
            string path = Application.persistentDataPath + directoryName + "/" + fileName;
            byte[] bytes = System.IO.File.ReadAllBytes (path);
            Texture2D texture = new Texture2D (1, 1);
            texture.LoadImage (bytes);
            Sprite sprite = Sprite.Create (texture, new Rect (0, 0, texture.width, texture.height), new Vector2 (0.5f, 0.5f));
            user_picture.sprite = sprite;
        }
    }
}