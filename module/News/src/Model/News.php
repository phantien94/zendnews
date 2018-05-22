<?php
namespace News\Model;

class News {

	//`idbv`, `lang`, `TieuDe`, `Alias`, `TomTat`, `urlHinh`, `Ngay`, `idUser`, `Content`, `idLoai`, `SoLanXem`, `NoiBat`, `AnHien`, `ThemYKien`

	public $idbv; 
	public $lang; 
	public $TieuDe; 
	public $Alias; 
	public $TomTat; 
	public $urlHinh; 
	public $Ngay; 
	public $idUser; 
	public $Content; 
	public $idLoai; 
	public $SoLanXem; 
	public $NoiBat; 
	public $AnHien; 
	public $ThemYKien;

	public function exchangeArray(array $data){
		$this->idbv     	= !empty($data['idbv']) ? $data['idbv'] : null;
		$this->lang     	= !empty($data['lang']) ? $data['lang'] : 'vi';
		$this->TieuDe     	= !empty($data['TieuDe']) ? $data['TieuDe'] : null;
		$this->Alias     	= !empty($data['Alias']) ? $data['Alias'] : null;
		$this->TomTat     	= !empty($data['TomTat']) ? $data['TomTat'] : null;
		$this->urlHinh     	= !empty($data['urlHinh']) ? $data['urlHinh'] : null;
		$this->Ngay     	= !empty($data['Ngay']) ? $data['Ngay'] : null;
		$this->idUser     	= !empty($data['idUser']) ? $data['idUser'] : null;
		$this->Content     	= !empty($data['Content']) ? $data['Content'] : null;
		$this->idLoai     	= !empty($data['idLoai']) ? $data['idLoai'] : 0;
		$this->SoLanXem     = !empty($data['SoLanXem']) ? $data['SoLanXem'] : 0;
		$this->NoiBat     	= !empty($data['NoiBat']) ? $data['NoiBat'] : 0;
		$this->AnHien     	= !empty($data['AnHien']) ? $data['AnHien'] : 1;
		$this->ThemYKien    = !empty($data['ThemYKien']) ? $data['ThemYKien'] : 1;

		
	}

	function getArrayCopy(){
        return get_object_vars($this);
    }
}