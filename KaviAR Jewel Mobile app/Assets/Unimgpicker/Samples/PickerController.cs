using System.Collections;
using System.Collections.Generic;
using OpenCVForUnityExample;
using UnityEngine;
using UnityEngine.SceneManagement;
using UnityEngine.UI;

namespace Kakera {
    public class PickerController : MonoBehaviour {
        public GameObject cam;
        public static Texture2D mytex;
        [SerializeField]
        private Unimgpicker imagePicker;

        [SerializeField]
        private Dropdown sizeDropdown;

        private int[] sizes = { 1024, 256, 16 };

        void Awake () {
            imagePicker.Completed += (string path) => {
                StartCoroutine (LoadImage (path));
            };
        }

        public void OnPressShowPicker () {
            imagePicker.Show ("Select Image", "unimgpicker", sizes[sizeDropdown.value]);

        }

        private IEnumerator LoadImage (string path) {
            var url = "file://" + path;
            var www = new WWW (url);
            yield return www;

            var texture = www.texture;
            mytex = www.texture;

            if (texture == null) {
                Debug.LogError ("Failed to load texture url:" + url);
            }
            if (SceneManager.GetActiveScene ().name == "TryOnRing") {
                cam.GetComponent<tryOnRing> ().useLoad ();
            } else if (SceneManager.GetActiveScene ().name == "TryOnWatch") {
                cam.GetComponent<tryOnWatch> ().useLoad ();
            }
        }
    }

}