#if !UNITY_WSA_10_0
using System;
using System.Collections;
using System.Collections.Generic;
using System.Diagnostics;
using Debug = UnityEngine.Debug;
using System.IO;
using Kakera;
using OpenCVForUnity.CoreModule;
using OpenCVForUnity.DnnModule;
using OpenCVForUnity.ImgcodecsModule;
using OpenCVForUnity.ImgprocModule;
using OpenCVForUnity.UnityUtils;
using UnityEditor;
using UnityEngine;
using UnityEngine.SceneManagement;
using UnityEngine.UI;

namespace OpenCVForUnityExample {

    /// <summary>
    /// OpenPose Example
    /// This example uses OpenPose human pose estimation network.
    /// Referring to https://github.com/opencv/opencv/blob/master/samples/dnn/openpose.py.
    /// </summary>
    public class tryOnWatch : MonoBehaviour {

        double deltaTime = 0.0;
        double fps = 0.0;
        public string operationType = "";
        [Header ("capture_ui")]
        public GameObject back_icon;
        public GameObject switch_cam_icon;
        public GameObject info_icon;
        public GameObject gallery_icon;
        public GameObject camera_icon;

        [Header ("processed_ui")]
        public GameObject reset_icon;
        public GameObject save_icon;
        public GameObject www_icon;
        public GameObject share_icon;
        public GameObject slider;
        AssetBundle localAssetBundle;
        GameObject prefab;
        string directoryName = "/Safe_Files";
        string prototextName = "/pose_deploy.prototxt";
        string modeltName = "/pose_iter_102000.caffemodel";
        string defaultModelsFolder = "/Default_projects";
        string directoryName1 = "/My_projects";
        string directoryName2 = "/Public_projects";

        Net net = null;
        public Text timeToComplete;
        public Text fpstext;
        public Text webcamtext;
        public Text framemat;

        GameObject watch;
        GameObject[] metalParts;
        GameObject[] beltParts;
        GameObject[] reverseParts;

        public List<Point> points = new List<Point> ();
        public Material goldMat;
        public Material silverMat;
        public Material blackMat;
        public Material leatherMat;
        public Material digitalMat;

        public GameObject q2;
        public WebCamTexture webCamTexture;
        WebCamDevice webCamDevice;

        //Opencv Mat
        public static Mat frame, frame_pot, frame_process;

        //Texture
        public static Texture2D texture;

        bool initDone = false;
        public static bool cap = true, initiate = true, proc = false, play = false;

        //Variable for GUI
        int indexCam = 0;
        public GameObject looktarget;
        public enum DATASET_TYPE {
            COCO,
            MPI,
            HAND
        }
        public DATASET_TYPE dataset = DATASET_TYPE.MPI;

        const float inWidth = 368;
        const float inHeight = 368;

        const float inScale = 1.0f / 255f;

        public Dictionary<string, int> BODY_PARTS;
        string[, ] POSE_PAIRS;

        string caffemodel_filepath;
        string prototxt_filepath;
        int fixrot = 90;
#if UNITY_WEBGL && !UNITY_EDITOR
        IEnumerator getFilePath_Coroutine;
#endif
        public GameObject loadingAnim;
        public GameObject movePhone;
        public GameObject errorAnim;
        public static bool show = false;
        public static bool error = false;
        public static bool startProcess = true;
        float origin_watch_rot_x;

        // Use this for initialization
        void Start () {
            int l = 127;
            byte v = (byte) l;
            RenderSettings.ambientLight = new Color32 (v, v, v, 1);
            instWatch ();
            q2.transform.localScale = new Vector3 (1280, 720, 1);

            if (webCamTexture != null) {
                webCamTexture.Stop ();
                initDone = false;
                frame.Dispose ();
            }
            if (webCamTexture == null) {
                webCamDevice = WebCamTexture.devices[indexCam];
                webCamTexture = new WebCamTexture (webCamDevice.name, /*width */ 720, 1280 /* height*/ );
            }

            // Starts the camera
            webCamTexture.Play ();

            if (webCamTexture.didUpdateThisFrame) {
                texture = new Texture2D (webCamTexture.width, webCamTexture.height, TextureFormat.RGB24, false);
                gameObject.GetComponent<Renderer> ().material.mainTexture = texture;
                initDone = true;
            }

            StartCoroutine (init ());
#if UNITY_ANDROID  
            this.gameObject.transform.rotation = Quaternion.Euler (0, 0, -fixrot);
#endif
#if UNITY_IOS
            this.gameObject.transform.rotation = Quaternion.Euler (0, 0, 0);
#endif
            if (dataset == DATASET_TYPE.HAND) {
                //prepare HAND parts
                BODY_PARTS = new Dictionary<string, int> () { { "Wrist", 0 }, { "ThumbMetacarpal", 1 }, { "ThumbProximal", 2 }, { "ThumbMiddle", 3 }, { "ThumbDistal", 4 }, { "IndexFingerMetacarpal", 5 }, { "IndexFingerProximal", 6 }, { "IndexFingerMiddle", 7 }, { "IndexFingerDistal", 8 }, { "MiddleFingerMetacarpal", 9 }, { "MiddleFingerProximal", 10 }, { "MiddleFingerMiddle", 11 }, { "MiddleFingerDistal", 12 }, { "RingFingerMetacarpal", 13 }, { "RingFingerProximal", 14 }, { "RingFingerMiddle", 15 }, { "RingFingerDistal", 16 }, { "LittleFingerMetacarpal", 17 }, { "LittleFingerProximal", 18 }, { "LittleFingerMiddle", 19 }, { "LittleFingerDistal", 20 }
                };

                POSE_PAIRS = new string[, ] { { "Wrist", "ThumbMetacarpal" }, { "ThumbMetacarpal", "ThumbProximal" }, { "ThumbProximal", "ThumbMiddle" }, { "ThumbMiddle", "ThumbDistal" }, { "Wrist", "IndexFingerMetacarpal" }, { "IndexFingerMetacarpal", "IndexFingerProximal" }, { "IndexFingerProximal", "IndexFingerMiddle" }, { "IndexFingerMiddle", "IndexFingerDistal" }, { "Wrist", "MiddleFingerMetacarpal" }, { "MiddleFingerMetacarpal", "MiddleFingerProximal" }, { "MiddleFingerProximal", "MiddleFingerMiddle" }, { "MiddleFingerMiddle", "MiddleFingerDistal" }, { "Wrist", "RingFingerMetacarpal" }, { "RingFingerMetacarpal", "RingFingerProximal" }, { "RingFingerProximal", "RingFingerMiddle" }, { "RingFingerMiddle", "RingFingerDistal" }, { "Wrist", "LittleFingerMetacarpal" }, { "LittleFingerMetacarpal", "LittleFingerProximal" }, { "LittleFingerProximal", "LittleFingerMiddle" }, { "LittleFingerMiddle", "LittleFingerDistal" }
                };
            }

#if UNITY_WEBGL && !UNITY_EDITOR
            // getFilePath_Coroutine = GetFilePath();
            // StartCoroutine(getFilePath_Coroutine);
#else
            //set model adn prototext
            caffemodel_filepath = Application.persistentDataPath + directoryName + modeltName;
            prototxt_filepath = Application.persistentDataPath + directoryName + prototextName;
            if (string.IsNullOrEmpty (caffemodel_filepath) || string.IsNullOrEmpty (prototxt_filepath)) {
                Debug.LogError (caffemodel_filepath + " or " + prototxt_filepath + " is not loaded. Please see \"StreamingAssets/dnn/setup_dnn_module.pdf\". ");
            } else {
                net = Dnn.readNet (prototxt_filepath, caffemodel_filepath);
            }
#endif
            //            Debug.Log (webCamTexture.videoRotationAngle);
        }

        void Update () {
            /*deltaTime += Time.deltaTime;
            deltaTime /= 2.0;
            fps = 1.0 / deltaTime;
            fpstext.text = "FPS : " + fps.ToString ("f0");*/
            //webcamtext.text = "width= " + webCamTexture.width + " - height=" + webCamTexture.height;
            //framemat.text = "col= " + frame.cols () + " - rows=" + frame.rows ();

            if (!initDone)
                return;

            if (show) {
                movePhone.SetActive (false);
                loadingAnim.SetActive (true);
            } else {
                loadingAnim.SetActive (false);
            }

            if (webCamTexture.didUpdateThisFrame) {
                if (cap) {
                    TextoMat ();
                    if (frame != null) {
                        MattoTex ();
                    }
                } else {
                    TextoMat ();
                    if (frame != null) {
                        q2.gameObject.SetActive (true);
                        show = false;
                        cap = true;
                        Process ();
                    }
                }
            }
        }

        void Process () {
            //if true, The error log of the Native side OpenCV will be displayed on the Unity Editor Console.
            // Utils.setDebugMode (true);
            error = false;
            Mat img = null;

            if (operationType == "frame") {
                img = frame_process;
            } else if (operationType == "picture") {
                img = new Mat (PickerController.mytex.height, PickerController.mytex.width, CvType.CV_8UC3, new Scalar (0, 0, 0));
                Utils.texture2DToMat (PickerController.mytex, img);
            }

            Imgproc.cvtColor (img, img, Imgproc.COLOR_RGB2BGR);
            Size sii = new Size (1280, 720);
            Imgproc.resize (img, img, sii);

            if (img.empty ()) {
                Debug.LogError (" image is not loaded. Please see \"StreamingAssets/dnn/setup_dnn_module.pdf\". ");
                img = new Mat (368, 368, CvType.CV_8UC3, new Scalar (0, 0, 0));
            }
            if (net == null) {
                Imgproc.putText (frame, "model file is not loaded.", new Point (5, frame.rows () - 30), Imgproc.FONT_HERSHEY_SIMPLEX, 0.7, new Scalar (255, 255, 255), 2, Imgproc.LINE_AA, false);
                Imgproc.putText (frame, "Please read console message.", new Point (5, frame.rows () - 10), Imgproc.FONT_HERSHEY_SIMPLEX, 0.7, new Scalar (255, 255, 255), 2, Imgproc.LINE_AA, false);
            } else {
                points = new List<Point> ();

                float frameWidth = img.cols ();
                float frameHeight = img.rows ();
                Mat input = Dnn.blobFromImage (img, inScale, new Size (inWidth, inHeight), new Scalar (0, 0, 0), false, false);

                net.setInput (input);

                //Stopwatch st = new Stopwatch ();
                //st.Start ();
                Mat output = net.forward ();
                // st.Stop ();
                //timeToComplete.text = "Method took " + (st.ElapsedMilliseconds / 1000).ToString ("f0") + " s to complete ";

                float[] data = new float[output.size (2) * output.size (3)];

                output = output.reshape (1, output.size (1));

                for (int i = 0; i < BODY_PARTS.Count; i++) {

                    output.get (i, 0, data);

                    Mat heatMap = new Mat (1, data.Length, CvType.CV_32FC1);
                    heatMap.put (0, 0, data);

                    //Originally, we try to find all the local maximums. To simplify a sample
                    //we just find a global one. However only a single pose at the same time
                    //could be detected this way.
                    Core.MinMaxLocResult result = Core.minMaxLoc (heatMap);

                    heatMap.Dispose ();

                    double x = (frameWidth * (result.maxLoc.x % 46)) / 46;
                    double y = (frameHeight * (result.maxLoc.x / 46)) / 46;

                    if (result.maxVal > 0.1) {
                        Point p = new Point (x, y);
                        points.Add (p);
                    } else {
                        points.Add (null);
                    }
                }
                bool check_error = checkErrorPoints ();
                if (check_error == false) {
                    /*  for (int i = 0; i < POSE_PAIRS.GetLength (0); i++) {
                          string partFrom = POSE_PAIRS[i, 0];
                          string partTo = POSE_PAIRS[i, 1];

                          int idFrom = BODY_PARTS[partFrom];
                          int idTo = BODY_PARTS[partTo];

                          if (points[idFrom] != null && points[idTo] != null) {
                              Imgproc.line (img, points[idFrom], points[idTo], new Scalar (0, 255, 0), 3);
                              Imgproc.ellipse (img, points[idFrom], new Size (3, 3), 0, 0, 360, new Scalar (0, 0, 255), Core.FILLED);
                              Imgproc.ellipse (img, points[idTo], new Size (3, 3), 0, 0, 360, new Scalar (0, 0, 255), Core.FILLED);
                          }
                      }*/

                    Point wrist_p = switchReference (points[0]);

                    Point look = points[9];
                    look = switchReference (look);

                    Point nine = switchReference (points[9]);
                    Point five = switchReference (points[5]);

                    double dist = Math.Sqrt ((Math.Pow (nine.x - five.x, 2) + Math.Pow (nine.y - five.y, 2)));
                    dist = dist * 3;

                    Vector3 poslook = new Vector3 ((float) look.x, (float) look.y, 300);
                    watch.transform.position = new Vector3 ((float) wrist_p.x, (float) wrist_p.y, 300);
                    looktarget.transform.position = poslook;
                    watch.transform.LookAt (looktarget.transform);

                    watch.transform.rotation = Quaternion.Euler (watch.transform.rotation.eulerAngles.x, 90, -90);

                    GameObject right = watch.transform.Find ("right").gameObject;
                    GameObject left = watch.transform.Find ("left").gameObject;

                    double watchWidth = Math.Sqrt ((Math.Pow (right.transform.position.x - left.transform.position.x, 2) + Math.Pow (right.transform.position.y - left.transform.position.y, 2)));

                    while (watchWidth < dist) {
                        float scale_step = 0.1f;
                        float s = watch.transform.localScale.x + scale_step;
                        watch.transform.localScale = new Vector3 (s, s, s);
                        watchWidth = Math.Sqrt ((Math.Pow (right.transform.position.x - left.transform.position.x, 2) + Math.Pow (right.transform.position.y - left.transform.position.y, 2)));
                    }
                    watch.transform.Translate (0, 0, -50);
                    Imgproc.cvtColor (img, img, Imgproc.COLOR_BGR2RGB);
                    //texture = new Texture2D (frame.cols (), frame.rows (), TextureFormat.RGBA32, false);
                    Texture2D texture1 = new Texture2D (img.cols (), img.rows (), TextureFormat.RGBA32, false);

                    Utils.matToTexture2D (img, texture1);

                    q2.gameObject.GetComponent<Renderer> ().material.mainTexture = texture1;
                    q2.gameObject.transform.rotation = Quaternion.Euler (0, 0, -fixrot);

                    //Utils.setDebugMode (false);

                    switch_cam_icon.SetActive (false);
                    info_icon.SetActive (false);
                    gallery_icon.SetActive (false);
                    camera_icon.SetActive (false);
                    slider.SetActive (true);

                    reset_icon.SetActive (true);
                    save_icon.SetActive (true);
                    www_icon.SetActive (true);
                    share_icon.SetActive (true);

                    origin_watch_rot_x = watch.transform.eulerAngles.x;

                } else {
                    error = true;
                    startProcess = false;
                    reset ();
                }
            }
        }

        void MattoTex () {
            Utils.matToTexture2D (frame, texture);
            gameObject.GetComponent<Renderer> ().material.shader = Shader.Find ("Mobile/Unlit (Supports Lightmap)");
            gameObject.GetComponent<Renderer> ().material.mainTexture = texture;
        }

        void TextoMat () {
            //Size s1 = new Size (640, 480);
            Size s1 = new Size (1280, 720);

            Imgproc.resize (frame, frame, s1);
            /* Debug.Log (img.cols ());
             Debug.Log (img.rows ());
             Debug.Log (texture.width);
             Debug.Log (texture.height);*/
            Utils.webCamTextureToMat (webCamTexture, frame);

            if (webCamTexture.videoVerticallyMirrored) {
                if (webCamDevice.isFrontFacing) {
                    if (webCamTexture.videoRotationAngle == 0) {
                        Core.flip (frame, frame, 1);
                    } else if (webCamTexture.videoRotationAngle == 90) {
                        Core.flip (frame, frame, 0);
                    } else if (webCamTexture.videoRotationAngle == 270) {
                        Core.flip (frame, frame, 1);
                    }
                } else {
                    if (webCamTexture.videoRotationAngle == 90) {

                    } else if (webCamTexture.videoRotationAngle == 270) {
                        Core.flip (frame, frame, -1);
                    }
                }
            } else {
                if (webCamDevice.isFrontFacing) {
                    if (webCamTexture.videoRotationAngle == 0) {
                        Core.flip (frame, frame, 1);
                    } else if (webCamTexture.videoRotationAngle == 90) {
                        Core.flip (frame, frame, 0);
                    } else if (webCamTexture.videoRotationAngle == 270) {
                        Core.flip (frame, frame, 1);
                    }
                } else {
                    if (webCamTexture.videoRotationAngle == 90) {

                    } else if (webCamTexture.videoRotationAngle == 270) {
                        Core.flip (frame, frame, -1);
                    }
                }
            }
        }

        public static void Capture () {
            if (cap) {
                cap = false;
            }
        }

        //switch camera
        public void SwitchCam () {
            if (indexCam == 0) {
                indexCam = 1;
                gameObject.transform.localScale = new Vector3 (-gameObject.transform.localScale.x, gameObject.transform.localScale.y, 1);
                webCamTexture.Stop ();
                webCamTexture.deviceName = webCamTexture.deviceName = WebCamTexture.devices[indexCam].name;
                webCamTexture.Play ();
            } else if (indexCam == 1) {
                indexCam = 0;
                gameObject.transform.localScale = new Vector3 (-gameObject.transform.localScale.x, gameObject.transform.localScale.y, 1);
                webCamTexture.Stop ();
                webCamTexture.deviceName = webCamTexture.deviceName = WebCamTexture.devices[indexCam].name;
                webCamTexture.Play ();
            }
        }

        public void incscale () {
            float current = watch.transform.localScale.x;
            float amount = 10;
            current = current + amount;
            watch.transform.localScale = new Vector3 (current, current, current);
        }
        public void decscale () {
            float current = watch.transform.localScale.x;
            float amount = 10;
            current = current - amount;
            watch.transform.localScale = new Vector3 (current, current, current);
        }

        public void rotateL () {
            float angle = watch.transform.eulerAngles.x;
            if (watch.transform.eulerAngles.x > origin_watch_rot_x - 10) {
                angle = angle - 2;
                watch.transform.rotation = Quaternion.Euler (angle, watch.transform.eulerAngles.y, watch.transform.eulerAngles.z);
            }
        }
        public void rotateR () {
            float angle = watch.transform.eulerAngles.x;
            if (watch.transform.eulerAngles.x < origin_watch_rot_x + 10) {
                angle = angle + 2;
                watch.transform.rotation = Quaternion.Euler (angle, watch.transform.eulerAngles.y, watch.transform.eulerAngles.z);
            }
        }

        public void translateU () {
            watch.transform.Translate (new Vector3 (0, 0, 2));
        }
        public void translateD () {
            watch.transform.Translate (new Vector3 (0, 0, -2));
        }

        public void translateR () {
            watch.transform.Translate (new Vector3 (2, 0, 0));
        }
        public void translateL () {
            watch.transform.Translate (new Vector3 (-2, 0, 0));
        }

        Point switchReference (Point p) {
            Point p2 = new Point ();

            p2.x = 360 - p.y;
            p2.y = 640 - p.x;

            return p2;
        }

        public void usecamera () {
            if (startProcess) {
                operationType = "frame";
                frame_process = frame;
                StartCoroutine (loadingManager.beginLoading ());
            }
        }

        public void reset () {
            if (error) {
                movePhone.SetActive (false);
                errorAnim.SetActive (true);
            } else {
                errorAnim.SetActive (false);
                movePhone.SetActive (true);
            }
            q2.gameObject.SetActive (false);
            watch.transform.position = new Vector3 (-124f, 1000, 111);
            watch.transform.rotation = Quaternion.identity;

            slider.SetActive (false);

            back_icon.SetActive (true);
            switch_cam_icon.SetActive (true);
            info_icon.SetActive (true);
            gallery_icon.SetActive (true);
            camera_icon.SetActive (true);

            reset_icon.SetActive (false);
            save_icon.SetActive (false);
            www_icon.SetActive (false);
            share_icon.SetActive (false);
        }

        void instWatch () {
            Debug.Log (data.beltColor);

            if (data.selected_personal_project == "" && data.selected_public_project == "") {
                localAssetBundle = AssetBundle.LoadFromFile (Path.Combine (Application.persistentDataPath + defaultModelsFolder, "watch"));
                prefab = localAssetBundle.LoadAsset<GameObject> ("watch" + (data.displayed + 1).ToString ());
            } else if (data.selected_personal_project != "" && data.selected_public_project == "") {
                localAssetBundle = AssetBundle.LoadFromFile (Path.Combine (Application.persistentDataPath + directoryName1, data.selected_personal_project + "_AB"));
                prefab = localAssetBundle.LoadAsset<GameObject> ("watch");
            } else if (data.selected_personal_project == "" && data.selected_public_project != "") {
                localAssetBundle = AssetBundle.LoadFromFile (Path.Combine (Application.persistentDataPath + directoryName2, data.selected_public_project + "_AB"));
                prefab = localAssetBundle.LoadAsset<GameObject> ("watch");
            }

            watch = Instantiate (prefab);
            localAssetBundle.Unload (false);

            metalParts = GameObject.FindGameObjectsWithTag ("metal");
            reverseParts = GameObject.FindGameObjectsWithTag ("reverse");

            if (watch.gameObject.tag == "color") {
                beltParts = GameObject.FindGameObjectsWithTag ("belt");
                beltParts = GameObject.FindGameObjectsWithTag ("belt");
                for (int i = 0; i < beltParts.Length; i++) {
                    if (beltParts[i] != null) {
                        beltParts[i].GetComponent<Renderer> ().material = leatherMat;
                    }
                }
                if (data.beltColor != null) {
                    if (data.changedB == true) {
                        for (int i = 0; i < beltParts.Length; i++) {
                            if (beltParts[i] != null) {
                                beltParts[i].GetComponent<Renderer> ().material.color = data.beltColor;
                            }
                        }
                    }
                }
            } else if (watch.gameObject.tag == "plastic") {
                if (data.changedP == true) {
                    watch.gameObject.transform.Find ("Hand_watch").GetComponent<Renderer> ().materials[2].color = data.beltColor;
                }
                GameObject plane = watch.transform.Find ("Plane").gameObject;
                plane.GetComponent<Renderer> ().material = digitalMat;
            }

            if (data.metalColorWatch == "silver") {
                selectSilver ();
            } else if (data.metalColorWatch == "gold") {
                selectGold ();
            } else if (data.metalColorWatch == "black") {
                selectBlack ();
            }
        }

        public void selectGold () {

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

        bool checkErrorPoints () {
            bool test = false;
            for (int i = 0; i < points.Count; i++) {
                if (points[i] == null) {
                    test = true;
                }
            }
            return test;
        }

        public void showInfo () {
            webCamTexture.Stop ();
            SceneManager.LoadScene ("WatchTuto", LoadSceneMode.Single);
        }

        public void useLoad () {
            if (startProcess) {
                operationType = "picture";
                StartCoroutine (loadingManager.beginLoading ());
            }
        }

        private IEnumerator init () {

            while (true) {
#if UNITY_IOS && !UNITY_EDITOR && (UNITY_4_6_3 || UNITY_4_6_4 || UNITY_5_0_0 || UNITY_5_0_1)
                if (webCamTexture.width > 16 && webCamTexture.height > 16) {
#else
                    if (webCamTexture.didUpdateThisFrame) {
#endif              

                        frame = new Mat (webCamTexture.height, webCamTexture.width, CvType.CV_8UC3);
                        frame_pot = new Mat (webCamTexture.width, webCamTexture.height, CvType.CV_8UC3);

                        texture = new Texture2D (webCamTexture.width, webCamTexture.height, TextureFormat.RGB24, false);
                        gameObject.transform.eulerAngles = new Vector3 (0, 0, 0);

                        gameObject.transform.rotation = gameObject.transform.rotation * Quaternion.AngleAxis (webCamTexture.videoRotationAngle, Vector3.back);
                        gameObject.transform.localScale = new Vector3 (webCamTexture.width, webCamTexture.height, 1);

#if UNITY_IOS
                        gameObject.transform.localScale = new Vector3 (-gameObject.transform.localScale.x, gameObject.transform.localScale.y, 1);
#endif
                        gameObject.GetComponent<Renderer> ().material.mainTexture = texture;

                        initDone = true;
                        break;
                    } else {
                        yield return 0;
                    }
                }
            }

        }
    }

#endif