<?php namespace App\Controllers;

use App\Models\BannerModel;
use App\Models\ProductModel;
use App\Models\ProfileModel;
use App\Models\CustomerModel;
use App\Models\TestimonialModel;
use App\Models\NotificationModel;

class Home extends BaseController
{
	public function __construct()
    {
		$this->notifModel = new NotificationModel();
		$this->profileModel	= new ProfileModel();
		$this->customerModel = new CustomerModel();
		$this->bannerModel	= new BannerModel();
		$this->productModel	= new ProductModel();
		$this->testimoniModel = new TestimonialModel();
	}
	
	public function index()
	{	 
		$data = [
			'notifications' => $this->notifModel->first(),
			'profile'	=> $this->profileModel->first(),
			'customers'	=> $this->customerModel->findAll(),
			'banners'	=> $this->bannerModel->findAll(),
			'products'	=> $this->productModel->findAll(),
			'testimonials'	=> $this->testimoniModel->findAll(),	
		];

		$data['socmed'] = json_decode($data['profile']['meta_socmed']);
		
		return view('web/index', $data);
	}

	public function send_message()
	{
		$name = $this->request->getPost('name');
		$question = $this->request->getPost('question');
		$profile = $this->profileModel->first();
		$socmed = \json_decode($profile['meta_socmed']);
		$url = 'https://wa.me/'.$socmed->whatsapp.'?text='.urlencode($question);

		return redirect()->to($url);
	}

	//--------------------------------------------------------------------

}
