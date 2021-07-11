using System;
using System.Collections;
using System.Collections.Generic;
using System.IO;
using UnityEngine;
using UnityEngine.UI;

public class ShareOnSocialMedia : MonoBehaviour {
	[SerializeField] GameObject watermark;
	[SerializeField] GameObject typeObject;
	[SerializeField] GameObject website;

	[Header ("processed_ui")]
	public GameObject reset_icon;
	public GameObject sldier;
	public GameObject save_icon;
	public GameObject www_icon;
	public GameObject share_icon;

	public GameObject backbutn;

	[Header ("slider buttons")]
	public GameObject arrow;
	public GameObject scaleB;
	public GameObject rotateB;
	public GameObject translateB;
	public GameObject slideBar;
	public GameObject lightingB;

	public void Share () {
		DateTime dt = DateTime.Now; //get the current date
		watermark.SetActive (true); //show the panel
		typeObject.SetActive (true);
		website.SetActive (true);
		reset_icon.SetActive (false);
		save_icon.SetActive (false);
		www_icon.SetActive (false);
		if (sldier.GetComponent<sliderButtonsManager> ().state) {
			sldier.GetComponent<sliderButtonsManager> ().hideShow ();
		}

		arrow.SetActive (false);
		scaleB.SetActive (false);
		rotateB.SetActive (false);
		translateB.SetActive (false);
		slideBar.SetActive (false);
		lightingB.SetActive (false);
		share_icon.SetActive (false);
		backbutn.SetActive (false);
		StartCoroutine ("TakeScreenShotAndShare");
	}

	IEnumerator TakeScreenShotAndShare () {
		yield return new WaitForEndOfFrame ();

		Texture2D tx = new Texture2D (Screen.width, Screen.height, TextureFormat.RGB24, false);
		tx.ReadPixels (new Rect (0, 0, Screen.width, Screen.height), 0, 0);
		tx.Apply ();

		string path = Path.Combine (Application.temporaryCachePath, "sharedImage.png"); //image name
		File.WriteAllBytes (path, tx.EncodeToPNG ());

		Destroy (tx); //to avoid memory leaks
		string fr_text = "Essaies toi aussi tes futurs bijoux en Réalité Augmentée gratuitement grâce à KaviAR [Jewel]";
		string eng_text = "Try your future Augmented Reality jewelry for free thanks to KaviAR [Jewel]";
		string msg = "";
		if (PlayerPrefs.GetString ("language") == "fr") {
			msg = fr_text;
		} else if (PlayerPrefs.GetString ("language") == "eng") {
			msg = eng_text;
		}
		new NativeShare ()
			.AddFile (path)
			.SetSubject ("This is my screenshot")
			.SetText (msg)
			.Share ();

		watermark.SetActive (false); //hide the panel
		typeObject.SetActive (false);
		website.SetActive (false);
		reset_icon.SetActive (true);
		save_icon.SetActive (true);
		www_icon.SetActive (true);

		arrow.SetActive (true);
		scaleB.SetActive (true);
		rotateB.SetActive (true);
		translateB.SetActive (true);
		slideBar.SetActive (true);
		lightingB.SetActive (true);

		share_icon.SetActive (true);
		backbutn.SetActive (true);
	}

	public void Save () {
		DateTime dt = DateTime.Now; //get the current date
		watermark.SetActive (true); //show the panel
		typeObject.SetActive (true);
		website.SetActive (true);
		reset_icon.SetActive (false);
		save_icon.SetActive (false);
		www_icon.SetActive (false);
		if (sldier.GetComponent<sliderButtonsManager> ().state) {
			sldier.GetComponent<sliderButtonsManager> ().hideShow ();
		}

		arrow.SetActive (false);
		scaleB.SetActive (false);
		rotateB.SetActive (false);
		translateB.SetActive (false);
		slideBar.SetActive (false);
		lightingB.SetActive (false);
		share_icon.SetActive (false);
		backbutn.SetActive (false);
		StartCoroutine ("TakeScreenShotAndSave");
	}

	IEnumerator TakeScreenShotAndSave () {
		yield return new WaitForEndOfFrame ();
		Texture2D tx = new Texture2D (Screen.width, Screen.height, TextureFormat.RGB24, false);
		tx.ReadPixels (new Rect (0, 0, Screen.width, Screen.height), 0, 0);
		tx.Apply ();

		NativeGallery.SaveImageToGallery (tx, "Kaviar[Jewel]", "Screenshot_KJ.png");
		watermark.SetActive (false); //hide the panel
		typeObject.SetActive (false);
		website.SetActive (false);
		reset_icon.SetActive (true);
		save_icon.SetActive (true);
		arrow.SetActive (true);
		scaleB.SetActive (true);
		rotateB.SetActive (true);
		translateB.SetActive (true);
		slideBar.SetActive (true);
		lightingB.SetActive (true);
		www_icon.SetActive (true);
		share_icon.SetActive (true);
		backbutn.SetActive (true);
	}
}