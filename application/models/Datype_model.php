<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datype_model extends MY_Model {

        public function __construct()
        {
                parent::__construct();
                  $this->_table = 'datype';
                  $this->_primaryKey = 'id';
        }

        protected function generateSalt() {
                $salt = "xiORG17N6ayoEn6X3";
                return $salt;
        }

        protected function generateVerificationKey() {
                $length = 10;
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
        }



// My code
		public  function addtype($data){
			
			 $sql_query=$this->db->insert("datype",$data);
			 // return true;
			 redirect('masters/datype');
		}
		
		public  function addcustomer($data){
			
			 $sql_query=$this->db->insert("party",$data);
			 // return true;
			 redirect('masters/customer');
		}
		
		public  function addcountry($data){
			
			 $sql_query=$this->db->insert("country",$data);
			 // return true;
			 redirect('masters/country');
		}
// My code ends 


        public function getUserIP() {
		    $ipaddress = '';
		    if (isset($_SERVER['HTTP_CLIENT_IP']))
		        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		    else if(isset($_SERVER['HTTP_X_FORWARDED']))
		        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		    else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
		        $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
		    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
		        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		    else if(isset($_SERVER['HTTP_FORWARDED']))
		        $ipaddress = $_SERVER['HTTP_FORWARDED'];
		    else if(isset($_SERVER['REMOTE_ADDR']))
		        $ipaddress = $_SERVER['REMOTE_ADDR'];
		    else
		        $ipaddress = 'UNKNOWN';
		    return $ipaddress;
	   }

        public function updateGroups($postData=null, $action=null) {
                if ($action == "add") {
                    $error = 0;
                    if (!isset($postData["name"]) || empty($postData["name"])) { $error = 2;} else { $name = $this->db->escape(strip_tags($postData["name"]));}
                    if ($error == 2) { return $error; }
                    $sql = "SELECT * FROM admin_groups WHERE name = ".$name;
                    $query = $this->db->query($sql);
                    if ($query->num_rows() > 0) {
                        return 3;
                    } else {
                        $sql2 = "INSERT INTO admin_groups (name) VALUES (".$name.")";
                        $this->db->query($sql2);
                        return TRUE;
                    }
                }
                if ($action == "edit") {
                    $error = 0;
                    if (!isset($postData["name"]) || empty($postData["name"])) { $error = 2;} else { $name = $this->db->escape(strip_tags($postData["name"]));}
                    if (!isset($postData["id"]) || empty($postData["id"])) { $error = 3;} else { $id = $this->db->escape(strip_tags($postData["id"]));}
                    if ($error == 2) { return $error; }
                    $sql = "SELECT * FROM admin_groups WHERE name = ".$name;
                    $query = $this->db->query($sql);
                    if ($query->num_rows() > 0) {
                        return 4;
                    } else {
                        $sql2 = "UPDATE admin_groups SET name = ".$name." WHERE id = ".$id;
                        $this->db->query($sql2);
                        return TRUE;
                    }
                }
                if ($action == "delete") {
                    $admin_group = $this->db->escape(strip_tags((int)$postData["id"]));
                    $sql = "SELECT * FROM admin WHERE admin_group = ".$admin_group;
                    $query = $this->db->query($sql);
                    if ($query->num_rows() > 0) {
                        return FALSE;
                    } else {
                        $sql2 = "DELETE FROM admin_groups WHERE id = ".$admin_group;
                        $this->db->query($sql2);
                        return TRUE;
                    }
                }
        }
        
        public function getAdminGroups($additional="") {
            if ($additional !== "") { $additional = "WHERE id = ".$this->db->escape($additional); }
            $sql = "SELECT * FROM admin_groups ".$additional;
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                return $query->result_array();
            } else {
                return array();
            }
        }

        public function getAdminInfo($adminid=null) {
            $sql = "SELECT * FROM admin WHERE id = ".$this->db->escape(strip_tags((int)$adminid));
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                return $query->row();
            } else {
                return array();
            }
        }

        public function getAdmins() {
                // $sql = "SELECT a.id, a.username, ag.name as 'role', a.name as 'fullname' FROM admin a 
                // LEFT JOIN admin_groups ag ON a.admin_group = ag.id";
				$sql = "SELECT a.id, a.datype FROM datype a ";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                        return $query->result_array();
                } else {
                        return array();
                }
        }
		
		public function getParty() {
                // table col name =	id 	party 	address1 	address2 	address3 	phone 	fax 	bankdetails 	ecgcinr

				$sql = "SELECT a.id, a.party, a.address1, a.address2, a.address3, a.phone, a.fax, a.bankdetails, a.ecgcinr FROM party a ";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                        return $query->result_array();
                } else {
                        return array();
                }
        }
		
		public function getCountry() {
                // table col name =	id 	party 	address1 	address2 	address3 	phone 	fax 	bankdetails 	ecgcinr

				//$sql = "SELECT a.id, a.country, a.territory FROM country a JOIN territory ON a.territory = territory.id";
			    $sql = "SELECT * FROM country JOIN territory ON territory.id = country.territory";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                        return $query->result_array();
                } else {
                        return array();
                }
        }
		
		public function getCurrency() {
                // table col name =	id 	party 	address1 	address2 	address3 	phone 	fax 	bankdetails 	ecgcinr

				$sql = "SELECT a.id, a.currency FROM currency a ";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                        return $query->result_array();
                } else {
                        return array();
                }
        }
		
		public  function addcurrency($data){
			
			 $sql_query=$this->db->insert("currency",$data);
			 // return true;
			 redirect('masters/currency');
		}
		
		
		// Shipment Mode
		public function getShipmentmode() {
                // table col name =	id 	party 	address1 	address2 	address3 	phone 	fax 	bankdetails 	ecgcinr

				$sql = "SELECT a.id, a.shippingmode FROM shippingmode a ";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                        return $query->result_array();
                } else {
                        return array();
                }
        }
		
		public function addshipmentmode($data){
			
			 $sql_query=$this->db->insert("shippingmode",$data);
			 // return true;
			 redirect('masters/shipmentmode');
		}
		
		
		
		
		//documentsrequired
		
		
		public function getDocumentsrequired() {
                // table col name =	id 	party 	address1 	address2 	address3 	phone 	fax 	bankdetails 	ecgcinr

				$sql = "SELECT a.id, a.documentsrequired FROM documentsrequired a ";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                        return $query->result_array();
                } else {
                        return array();
                }
        }
		
		public function adddocumentsrequired($data){
			
			 $sql_query=$this->db->insert("documentsrequired",$data);
			 // return true;
			 redirect('masters/documentsrequired');
		}
		
		
		//territory
		
		
		public function getTerritory() {
                // table col name =	id 	territory

				$sql = "SELECT a.id, a.territory FROM territory a ";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                        return $query->result_array();
                } else {
                        return array();
                }
        }
		
		public function addterritory($data){
			
			 $sql_query=$this->db->insert("territory",$data);
			 // return true;
			 redirect('masters/territory');
		}
		
				
		
		//label
		
		
		public function getLabel() {
                // table col name =	id 	label

				$sql = "SELECT a.id, a.label FROM label a ";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                        return $query->result_array();
                } else {
                        return array();
                }
        }
		
		public function addlabel($data){
			
			 $sql_query=$this->db->insert("label",$data);
			 // return true;
			 redirect('masters/label');
		}
		
				
				
				
		
		//productform
		
		
		public function getProductform() {
                // table col name =	id 	productform

				$sql = "SELECT * FROM productform ";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                        return $query->result_array();
                } else {
                        return array();
                }
        }
		
		public function addproductform($data){
			
			 $sql_query=$this->db->insert("productform",$data);
			 // return true;
			 redirect('masters/productform');
		}
		
				
		
		//despatchto
		
		
		public function getDespatchto() {
                // table col name =	id 	despatchto

				$sql = "SELECT a.id, a.despatchto FROM despatchto a ";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                        return $query->result_array();
                } else {
                        return array();
                }
        }
		
		public function adddespatchto($data){
			
			 $sql_query=$this->db->insert("despatchto",$data);
			 // return true;
			 redirect('masters/despatchto');
		}
		
				
		
		//transportmodetocha
		
		
		public function getTransportmodetocha() {
                // table col name =	id 	territory

				$sql = "SELECT a.id, a.transportmodetocha FROM transportmodetocha a ";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                        return $query->result_array();
                } else {
                        return array();
                }
        }
		
		public function addtransportmodetocha($data){
			
			 $sql_query=$this->db->insert("transportmodetocha",$data);
			 // return true;
			 redirect('masters/transportmodetocha');
		}
		
						
				
		
		//productgrade
		
		
		public function getProductgrade() {
                // table col name =	id 	productgrade

				$sql = "SELECT a.id, a.productgrade FROM productgrade a ";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                        return $query->result_array();
                } else {
                        return array();
                }
        }
		
		public function addproductgrade($data){
			
			 $sql_query=$this->db->insert("productgrade",$data);
			 // return true;
			 redirect('masters/productgrade');
		}
		
				
		//marketingperson
		
		
		public function getMarketingperson() {
                // table col name =	id 	marketingperson

				$sql = "SELECT a.id, a.marketingperson FROM marketingperson a ";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                        return $query->result_array();
                } else {
                        return array();
                }
        }
		
		public function addmarketingperson($data){
			
			 $sql_query=$this->db->insert("marketingperson",$data);
			 // return true;
			 redirect('masters/marketingperson');
		}
		
		
		//deliveryterm
		
		
		public function getDeliveryterm() {
                // table col name =	id 	deliveryterm

				$sql = "SELECT a.id, a.deliveryterm FROM deliveryterm a ";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                        return $query->result_array();
                } else {
                        return array();
                }
        }
		
		public function adddeliveryterm($data){
			
			 $sql_query=$this->db->insert("deliveryterm",$data);
			 // return true;
			 redirect('masters/deliveryterm');
		}
		
		
		//paymentterms
		
		
		public function getPaymentterms() {
                // table col name =	id 	paymentterms

				$sql = "SELECT a.id, a.paymentterms FROM paymentterms a ";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                        return $query->result_array();
                } else {
                        return array();
                }
        }
		
		public function addpaymentterms($data){
			
			 $sql_query=$this->db->insert("paymentterms",$data);
			 // return true;
			 redirect('masters/paymentterms');
		}
				
		
		//kindofpackages
		
		
		public function getKindofpackages() {
                // table col name =	id 	kindofpackages datype

				$sql = "SELECT * FROM kindofpackages JOIN datype ON datype.id = kindofpackages.datype ";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                        return $query->result_array();
                } else {
                        return array();
                }
        }
		
		public function addkindofpackages($data){
			
			 $sql_query=$this->db->insert("kindofpackages",$data);
			 // return true;
			 redirect('masters/kindofpackages');
		}
				
		
		//product
		
		
		public function getProduct() {
                // table col name =	id 	kindofpackages datype

				$sql = "SELECT * FROM product JOIN datype ON datype.id = product.datype";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                        return $query->result_array();
                } else {
                        return array();
                }
        }
		
		public function addproduct($data){
			
			 $sql_query=$this->db->insert("product",$data);
			 // return true;
			 redirect('masters/product');
		}
		
		//agent
		
		public function getAgent() {
                // table col name =	id 	party 	address1 	address2 	address3 	phone 	fax 	bankdetails 	ecgcinr

				$sql = "SELECT a.id, a.agent FROM agent a ";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                        return $query->result_array();
                } else {
                        return array();
                }
        }
		
		public function addagent($data){
			
			 $sql_query=$this->db->insert("agent",$data);
			 // return true;
			 redirect('masters/agent');
		}
		
		

        public function updateAdmins($postData=null, $action=null) {
                if ($action == "add") {
                        $error = 0;
                        if (!isset($postData["username"]) || empty($postData["username"])) { $error = 2;} else { $username = $this->db->escape(strip_tags($postData["username"]));}
                        if (!isset($postData["password"]) || empty($postData["password"])) { $error = 3;} else { $password = strip_tags($postData["password"]);}
                        if (!isset($postData["password2"]) || empty($postData["password2"])) { $error = 4;} else { $password2 = strip_tags($postData["password2"]);}
                        if (!isset($postData["email"]) || empty($postData["email"])) { $error = 5;} else { $email = $this->db->escape(strip_tags($postData["email"]));}
                        if (!isset($postData["name"]) || empty($postData["name"])) { $error = 6;} else { $name = $this->db->escape(strip_tags($postData["name"]));}
                        if (!isset($postData["admin_group"]) || empty($postData["admin_group"])) { $error = 7;} else { $admin_group = $this->db->escape(strip_tags($postData["admin_group"]));} 
                        if (!isset($postData["address"]) || empty($postData["address"])) { $address = "''";} else { $address = $this->db->escape(strip_tags($postData["address"]));} 
                        if (!isset($postData["address2"]) || empty($postData["address2"])) { $address2 = "''";} else { $address2 = $this->db->escape(strip_tags($postData["address2"]));} 
                        if (!isset($postData["city"]) || empty($postData["city"])) { $city = "''";} else { $city = $this->db->escape(strip_tags($postData["city"]));} 
                        if (!isset($postData["state"]) || empty($postData["state"])) { $state = "''";} else { $state = $this->db->escape(strip_tags($postData["state"]));} 
                        if (!isset($postData["zip"]) || empty($postData["zip"])) { $zip = "''";} else { $zip = $this->db->escape(strip_tags($postData["zip"]));}   
                        $verification_key = $this->db->escape($this->generateVerificationKey());
                        $salt = $this->generateSalt();
                        if ($password !== $password2) { $error = 8; } else { $password = $this->db->escape(md5($salt.$password)); }
                        if ($error > 0) { return $error; }
                        $now = $this->db->escape(time());
                        $sql = "SELECT * FROM admin WHERE username = ".$username;
                        $query = $this->db->query($sql);
                        if ($query->num_rows() > 0) {
                                return 9;
                        } else {
                                $sql2 = "INSERT INTO admin (username,password,email,created_date,verification_key,admin_group,name,address,address2,city,state,zip) VALUES ($username, $password, $email, $now, $verification_key, $admin_group, $name, $address, $address2, $city, $state, $zip)";
                                $this->db->query($sql2);
                                return TRUE;   
                        }
                        
                }
                if ($action == "edit") {
                        $error = 0; 
                        if (!isset($postData["username"]) || empty($postData["username"])) { $username = ""; } else { $username = $this->db->escape(strip_tags($postData["username"]));}
                        if (!isset($postData["password"]) || empty($postData["password"])) { $pass = 0; } else { $pass = 1; $password = strip_tags($postData["password"]);}
                        if (!isset($postData["password2"]) || empty($postData["password2"])) { $password2 = "";} else { $password2 = strip_tags($postData["password2"]);}
                        if (!isset($postData["email"]) || empty($postData["email"])) { $error = 5;} else { $email = $this->db->escape(strip_tags($postData["email"]));}
                        if (!isset($postData["name"]) || empty($postData["name"])) { $error = 6;} else { $name = $this->db->escape(strip_tags($postData["name"]));}
                        if (!isset($postData["admin_group"]) || empty($postData["admin_group"])) { $error = 7;} else { $admin_group = $this->db->escape(strip_tags($postData["admin_group"]));} 
                        if (!isset($postData["address"]) || empty($postData["address"])) { $address = "''";} else { $address = $this->db->escape(strip_tags($postData["address"]));} 
                        if (!isset($postData["address2"]) || empty($postData["address2"])) { $address2 = "''";} else { $address2 = $this->db->escape(strip_tags($postData["address2"]));} 
                        if (!isset($postData["city"]) || empty($postData["city"])) { $city = "''";} else { $city = $this->db->escape(strip_tags($postData["city"]));} 
                        if (!isset($postData["state"]) || empty($postData["state"])) { $state = "''";} else { $state = $this->db->escape(strip_tags($postData["state"]));} 
                        if (!isset($postData["zip"]) || empty($postData["zip"])) { $zip = "''";} else { $zip = $this->db->escape(strip_tags($postData["zip"]));}   
                        if ($error > 0) { return $error; }
                        $sql = "SELECT * FROM admin WHERE username = ".$username; 
                        $query = $this->db->query($sql);
                        if ($query->num_rows() > 0) {
                                if ($pass == 0) {
                                    $sql = "UPDATE admin SET email = $email, name = $name, admin_group = $admin_group, address = $address, address2 = $address2, city = $city, state = $state, zip = $zip WHERE id = ".$this->db->escape($query->row()->id);
                                    $this->db->query($sql);
                                    return TRUE;
                                } else {
                                    if ($password !== $password2) { return 8; }
                                    $salt = $this->generateSalt();
                                    $password = $this->db->escape(md5($salt.$password));
                                    $sql = "UPDATE admin SET email = $email, name = $name, admin_group = $admin_group, address = $address, address2 = $address2, city = $city, state = $state, zip = $zip, password = $password WHERE id = ".$this->db->escape($query->row()->id);
                                    $this->db->query($sql);
                                    return TRUE;
                                }   
                        } else {
                                return 9;
                        }
                }
                if ($action == "delete") {
                        $admin_id = $this->db->escape(strip_tags((int)$postData["id"]));
                        if ((int)$postData["id"] == $this->session->userdata("admin_id")) { 
                                return FALSE;
                        } else {
                           $sql = "DELETE FROM admin WHERE id = ".$admin_id;
                           $this->db->query($sql);
                           return TRUE;     
                        }
                        
                }
        }

        public function adminLogin($postData) {
        	if (!isset($postData["username"])) { return 2; }
        	if (!isset($postData["password"])) { return 2; }
                $salt = $this->generateSalt();
        	$username = $this->db->escape(strip_tags($postData["username"]));
        	$password = $this->db->escape(strip_tags(md5($salt.$postData["password"])));
        	$sql = "SELECT * FROM admin WHERE username = ".$username." AND password = ".$password;
        	$query = $this->db->query($sql);
        	if ($query->num_rows() > 0) {
        		$q = $query->row();
        		$this->session->set_userdata("username",$q->username);
        		$this->session->set_userdata("verification_key",$q->verification_key);
        		$this->session->set_userdata("admin_id", $q->id);
        		$this->session->set_userdata("loggedin",1);
        		$ip = $this->getUserIP();
        		$sql2 = "UPDATE admin SET last_signin = NOW(), ip = ".$this->db->escape($ip)." WHERE id = ".$q->id;
        		$this->db->query($sql2);
        		return TRUE;
        	} else {
        		return 2;
        	}
        }

        public function verifyUser() {
        	if ($this->session->userdata("username") && $this->session->userdata("verification_key") && $this->session->userdata("admin_id") && $this->session->userdata("loggedin")) {
        		$sql = "SELECT * FROM admin WHERE id = ".$this->db->escape(strip_tags((int)$this->session->userdata("admin_id")))." AND verification_key = ".$this->db->escape(strip_tags($this->session->userdata("verification_key")))." AND username = ".$this->db->escape(strip_tags($this->session->userdata("username")));
        		$query = $this->db->query($sql);
        		if ($query->num_rows() > 0) {
        			return TRUE;
        		} else {
        			$this->logout();
        			redirect(base_url()."login", 'auto');
        		}
        	} else {
        		$this->logout();
        		redirect(base_url()."login", 'auto');
        	}
        }

        public function logout() {
        	$this->session->unset_userdata("username");
        	$this->session->unset_userdata("verification_key");
        	$this->session->unset_userdata("admin_id");
        	$this->session->unset_userdata("loggedin");
        	return TRUE;
        }

}