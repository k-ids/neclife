<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Daheader_model extends MY_Model {

    function __construct() {
        $this->_table = 'daheader';
        $this->_primaryKey = 'id';
        $this->_table_1 = 'daitems';
    }   

    public function da_entry($where = null, $type = null, $datype = null) {

        $select = "".$this->_table.".da_no,".$this->_table.".financial_year,".$this->_table.".financial_year,".$this->_table.".da_type,".$this->_table.".da_date,".$this->_table.".id, ".$this->_table.".da_revised, ".$this->_table.".cancelled_by, ".$this->_table.".cancel_date, ".$this->_table.".cancel_remarks, ".$this->_table.".checked_by, ".$this->_table.".buyer, ".$this->_table.".created_at, ".$this->_table.".payement_recieved, party.party, product.product as product_name, datype.datype as datype_name, department.department as department_name, exportinvoiceheader.invoice_id as invoice_id, exportinvoiceheader.ad_lic_no as advance_license_no, plantpackinglist.da_no as plant_da_no, exportinvoiceheader.invoice_type"; 
        
        $this->db->select( $select );
        $this->db->from($this->_table);
        $this->db->join('party', $this->_table.'.buyer = party.id', 'left');
        $this->db->join('daitems', $this->_table.'.id = daitems.da_no', 'left');
        $this->db->join('datype', $this->_table.'.da_type = datype.id', 'left');
        $this->db->join('department', $this->_table.'.department = department.id', 'left');
        $this->db->join('product', 'daitems.product = product.id', 'left');
        $this->db->join('exportinvoiceheader', 'daheader.id = exportinvoiceheader.da_no', 'left');
        $this->db->join('plantpackinglist', 'daheader.id =  plantpackinglist.da_no', 'left');

        if(!empty($where)) {
             $this->db->where($this->_table.'.buyer',$where);
        }
        if(!empty($type)) {
             $this->db->where($type);
        }
        if(!empty($datype)) {
             $this->db->where($datype);
             //$this->db->where($this->_table.'.cancelled', 0);
        }
        $this->db->where($this->_table.'.financial_year', $this->session->userdata('financial_year'));
        
        $this->_userDaDepartments(); // get data on da type and department basis conditonal global function : location: Core -> My_Model.php
        $this->_userRoles();  // get data when user role is PPIC: location: Core -> My_Model.php

        $this->db->group_by($this->_table.'.id'); 
        $this->db->order_by('id', 'DESC');

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }


    public function da_entry_packing_list($where = null, $type = null, $datype = null) {

        $select = "".$this->_table.".da_no, ".$this->_table.".financial_year,".$this->_table.".da_type,".$this->_table.".da_date,".$this->_table.".id, ".$this->_table.".da_revised, ".$this->_table.".cancelled_by, ".$this->_table.".cancel_date, ".$this->_table.".cancel_remarks, ".$this->_table.".checked_by, ".$this->_table.".buyer, ".$this->_table.".created_at, ".$this->_table.".payement_recieved, party.party, product.product as product_name, datype.datype as datype_name, department.department as department_name,   exportinvoiceheaderpacking.invoice_id as packing_invoice_id, plantpackinglist.da_no as plant_da_no, exportinvoiceheaderpacking.invoice_type"; 
        
        $this->db->select( $select );
        $this->db->from($this->_table);
        $this->db->join('party', $this->_table.'.buyer = party.id', 'left');
        $this->db->join('daitems', $this->_table.'.id = daitems.da_no', 'left');
        $this->db->join('datype', $this->_table.'.da_type = datype.id', 'left');
        $this->db->join('department', $this->_table.'.department = department.id', 'left');
        $this->db->join('product', 'daitems.product = product.id', 'left');
        //$this->db->join('packing_list_invoice', 'daheader.id = packing_list_invoice.da_no', 'left');
        $this->db->join('exportinvoiceheaderpacking', 'daheader.id = exportinvoiceheaderpacking.da_no', 'left');
        $this->db->join('plantpackinglist', 'daheader.id =  plantpackinglist.da_no', 'left');

        if(!empty($where)) {
             $this->db->where($this->_table.'.buyer',$where);
        }
        if(!empty($type)) {
             $this->db->where($type);
        }
        if(!empty($datype)) {
             $this->db->where($datype);
             //$this->db->where($this->_table.'.cancelled', 0);
        }
        $this->db->where($this->_table.'.financial_year', $this->session->userdata('financial_year'));
         

        $this->_userDaDepartments();
        $this->_userRoles();

        $this->db->group_by($this->_table.'.id'); 
        $this->db->order_by('id', 'DESC');

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function get_all_da_entry($where = null, $type = null, $datype = null) {

        $select = "".$this->_table.".da_no, ".$this->_table.".financial_year,".$this->_table.".da_type,".$this->_table.".da_date,".$this->_table.".id, ".$this->_table.".da_revised, ".$this->_table.".cancelled_by, ".$this->_table.".cancel_date, ".$this->_table.".cancel_remarks, ".$this->_table.".checked_by, ".$this->_table.".buyer, ".$this->_table.".created_at, ".$this->_table.".payement_recieved, party.party, product.product as product_name, datype.datype as datype_name, department.department as department_name, COUNT(daattachment.id) as daattachment_num"; 
        
    	$this->db->select( $select );
		$this->db->from($this->_table);
		$this->db->join('party', $this->_table.'.buyer = party.id', 'left');
        $this->db->join('daitems', $this->_table.'.id = daitems.da_no', 'left');
        $this->db->join('datype', $this->_table.'.da_type = datype.id', 'left');
        $this->db->join('department', $this->_table.'.department = department.id', 'left');
        $this->db->join('product', 'daitems.product = product.id', 'left');
        $this->db->join('daattachment', $this->_table.'.id = daattachment.da_no', 'left');

    	if(!empty($where)) {
             $this->db->where($this->_table.'.buyer',$where);
    	}
        if(!empty($type)) {
             $this->db->where($type);
        }
        if(!empty($datype)) {
             $this->db->where($datype);
             //$this->db->where($this->_table.'.cancelled', 0);
        }
        $this->db->where($this->_table.'.financial_year', $this->session->userdata('financial_year'));

        $this->_userDaDepartments(); // get data on da type and department basis conditonal global function : location: Core -> My_Model.php
        $this->_userRoles();  // get data when user role is PPIC: location: Core -> My_Model.php

    	$this->db->group_by($this->_table.'.id'); 
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
    	$result = $query->result_array();
    	return $result;
    }

    public function findHeaderItems ($where) {

        $select = "".$this->_table.".*, party.party as buyer_name,datype.datype as datype_name, country.country as county_name, deliveryterm.deliveryterm, paymentterms.paymentterms, shippingmode.shippingmode, label.label as label_name, despatchto.despatchto, agent.agent as agent_name, transportmodetocha.transportmodetocha , declaration.declaration as declaration1, users.user as order_by, currency.currency as currency_name,admin.username, datype_address.address, datype_address.pan_no,
         datype_address.ie_code_no, datype_address.cin_no, datype_address.gstin, datype_address.tin_number, datype_address.state, datype_address.state_code, datype_address.state_of_origin, datype_address.district_code, datype_address.district_of_origin";

        $this->db->select($select);
        $this->db->from($this->_table);
        $this->db->join('datype', $this->_table.'.da_type = datype.id', 'left');
        $this->db->join('party', $this->_table.'.buyer = party.id', 'left');
        $this->db->join('country', $this->_table.'.country = country.id', 'left');
        $this->db->join('deliveryterm', $this->_table.'.term_of_delivery = deliveryterm.id', 'left');
        $this->db->join('paymentterms', $this->_table.'.payment_terms = paymentterms.id', 'left');
        $this->db->join('shippingmode', $this->_table.'.shipping_mode = shippingmode.id', 'left');
        $this->db->join('label', $this->_table.'.label = label.id', 'left');
        $this->db->join('despatchto', $this->_table.'.despatch_to = despatchto.id', 'left');
        $this->db->join('transportmodetocha', $this->_table.'.transport_mode_to_cha = transportmodetocha.id', 'left');
        $this->db->join('agent', $this->_table.'.agent = agent.id', 'left');
        $this->db->join('declaration', $this->_table.'.declaration = declaration.id', 'left');
        $this->db->join('users', $this->_table.'.ordered_by = users.id', 'left');
        $this->db->join('currency', $this->_table.'.currency = currency.id', 'left');
        $this->db->join('admin', $this->_table.'.ordered_by = admin.id', 'left');
        $this->db->join('datype_address', $this->_table.'.da_type = datype_address.da_type', 'left');

        if(!empty($where)) {
            $this->db->where($this->_table.'.id', $where);
        }
        $this->db->where($this->_table.'.financial_year', $this->session->userdata('financial_year'));

        $query = $this->db->get();
        $result = $query->row_array();

        return $result;
    }

    public function get_result($da_type = '', $first_date ='', $second_date = '') {
        
        $select = "".$this->_table.".*, daitems.*, datype.datype as datype_name, country.country as county_name, territory.territory, deliveryterm.deliveryterm, paymentterms.paymentterms, shippingmode.shippingmode, label.label as label_name, despatchto.despatchto, agent.agent as agent_name, transportmodetocha.transportmodetocha , declaration.declaration as declaration1, users.user as order_by, currency.currency as currency_name, product.product as product_name, productform.productform, productgrade.productgrade, kindofpackages.kindofpackages";

        $this->db->select($select);
        $this->db->from($this->_table);

        $this->db->join('daitems', $this->_table.'.id = daitems.da_no', 'left');
        $this->db->join('datype', $this->_table.'.da_type = datype.id', 'left');
        $this->db->join('country', $this->_table.'.country = country.id', 'left');
        $this->db->join('territory', 'country.territory = territory.id', 'left');
        $this->db->join('deliveryterm', $this->_table.'.term_of_delivery = deliveryterm.id', 'left');
        $this->db->join('paymentterms', $this->_table.'.payment_terms = paymentterms.id', 'left');
        $this->db->join('shippingmode', $this->_table.'.shipping_mode = shippingmode.id', 'left');
        $this->db->join('label', $this->_table.'.label = label.id', 'left');
        $this->db->join('despatchto', $this->_table.'.despatch_to = despatchto.id', 'left');
        $this->db->join('transportmodetocha', $this->_table.'.transport_mode_to_cha = transportmodetocha.id', 'left');
        $this->db->join('agent', $this->_table.'.agent = agent.id', 'left');
        $this->db->join('declaration', $this->_table.'.declaration = declaration.id', 'left');
        $this->db->join('users', $this->_table.'.ordered_by = users.id', 'left');
        $this->db->join('currency', $this->_table.'.currency = currency.id', 'left');

        $this->db->join('product', $this->_table_1.'.product = product.id','left');
        $this->db->join('productform', $this->_table_1.'.product_form = productform.id', 'left');
        $this->db->join('productgrade', $this->_table_1.'.grade = productgrade.id', 'left');
        $this->db->join('kindofpackages', $this->_table_1.'.packing_type = kindofpackages.id', 'left');


        if(!empty($where)) {
            $this->db->where($this->_table.'.id', $where);
        }

        $this->db->where('daheader.da_type', $da_type);
        $this->db->where('daheader.created_at >=', $first_date);
        $this->db->where('daheader.created_at <=', $second_date);
        $this->db->where($this->_table.'.financial_year', $this->session->userdata('financial_year'));
        
        $this->_userDaDepartments(); // get data on da type and department basis conditonal global function : location: Core -> My_Model.php
        $this->_userRoles();  // get data when user role is PPIC: location: Core -> My_Model.php

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function getLastRecord($da_type = '', $financial_year = '', $type = '') {

        $this->db->select("id, da_no, financial_year, da_type");
        $this->db->from($this->_table);
        $this->db->where('da_type', $da_type );
        $this->db->where('financial_year', $financial_year);
        $this->db->where('type', $type);
        $this->db->limit(1);
        $this->db->order_by('id',"DESC");
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function all_api_da_entry($where = null, $type = null, $datype = null) {

        $select = "".$this->_table.".da_no, ".$this->_table.".financial_year,".$this->_table.".da_type,".$this->_table.".da_date,".$this->_table.".id, ".$this->_table.".da_revised, ".$this->_table.".cancelled_by, ".$this->_table.".cancel_date, ".$this->_table.".cancel_remarks, ".$this->_table.".checked_by, ".$this->_table.".buyer, ".$this->_table.".created_at, ".$this->_table.".payement_recieved, party.party, product.product as product_name, datype.datype as datype_name, department.department as department_name, gsk_packing.da_no as gskDa"; 
        
        $this->db->select( $select );
        $this->db->from($this->_table);
        $this->db->join('party', $this->_table.'.buyer = party.id', 'left');
        $this->db->join('daitems', $this->_table.'.id = daitems.da_no', 'left');
        $this->db->join('datype', $this->_table.'.da_type = datype.id', 'left');
        $this->db->join('department', $this->_table.'.department = department.id', 'left');
        $this->db->join('product', 'daitems.product = product.id', 'left');
        $this->db->join('gsk_packing', 'daheader.id = gsk_packing.da_no', 'left');
        
        if(!empty($where)) {
             $this->db->where($this->_table.'.buyer',$where);
        }
        if(!empty($type)) {
             $this->db->where($type);
        }
        if(!empty($datype)) {
             $this->db->where($datype);
             
        }
        
        $this->db->where($this->_table.'.cancelled', 0);
        $this->db->where($this->_table.'.da_type', ADMIN);

        $this->db->where($this->_table.'.financial_year', $this->session->userdata('financial_year'));
        
        $this->_userDaDepartments(); // get data on da type and department basis conditonal global function : location: Core -> My_Model.php
        $this->_userRoles();  // get data when user role is PPIC: location: Core -> My_Model.php

        $this->db->group_by($this->_table.'.id'); 
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function all_api_da_entry_for_gsk_invoice($where = null, $type = null, $datype = null) {

        $select = "".$this->_table.".da_no, ".$this->_table.".financial_year,".$this->_table.".da_type,".$this->_table.".da_date,".$this->_table.".id, ".$this->_table.".da_revised, ".$this->_table.".cancelled_by, ".$this->_table.".cancel_date, ".$this->_table.".cancel_remarks, ".$this->_table.".checked_by, ".$this->_table.".buyer, ".$this->_table.".created_at, ".$this->_table.".payement_recieved, party.party,  datype.datype as datype_name, department.department as department_name, export_gsk_invoice_header.invoice_id as gsk_invoice_id"; 
        
        $this->db->select( $select );
        $this->db->from($this->_table);
        $this->db->join('party', $this->_table.'.buyer = party.id', 'left');
        $this->db->join('datype', $this->_table.'.da_type = datype.id', 'left');
        $this->db->join('department', $this->_table.'.department = department.id', 'left');
        $this->db->join('gsk_packing', $this->_table.'.da_no = gsk_packing.da_no', 'left');
        $this->db->join('gsk_packing_map', $this->_table.'.da_no = gsk_packing_map.da_no', 'left');
        $this->db->join('export_gsk_invoice_header', $this->_table.'.id = export_gsk_invoice_header.da_no', 'left');

        if(!empty($where)) {
             $this->db->where($this->_table.'.buyer',$where);
        }
        if(!empty($type)) {
             $this->db->where($type);
        }
        if(!empty($datype)) {
             $this->db->where($datype);
             //$this->db->where($this->_table.'.cancelled', 0);
        }

        $this->db->where($this->_table.'.da_type', ADMIN);
        $this->db->where($this->_table.'.financial_year', $this->session->userdata('financial_year'));
         
        $this->_userDaDepartments(); // get data on da type and department basis conditonal global function : location: Core -> My_Model.php
        $this->_userRoles();  // get data when user role is PPIC: location: Core -> My_Model.php

        $this->db->group_by($this->_table.'.id'); 
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function getAllDAForPPIC($where = null, $conditionsCheckArray = null) {

        $select = "".$this->_table.".da_no, ".$this->_table.".financial_year,".$this->_table.".da_type,".$this->_table.".da_date,".$this->_table.".id, ".$this->_table.".da_revised, ".$this->_table.".cancelled_by, ".$this->_table.".cancel_date, ".$this->_table.".cancel_remarks, ".$this->_table.".checked_by, ".$this->_table.".buyer, ".$this->_table.".created_at, ".$this->_table.".payement_recieved, party.party, product.product as product_name, datype.datype as datype_name, department.department as department_name"; 
        
        $this->db->select( $select );
        $this->db->from($this->_table);
        $this->db->join('party', $this->_table.'.buyer = party.id', 'left');
        $this->db->join('daitems', $this->_table.'.id = daitems.da_no', 'left');
        $this->db->join('datype', $this->_table.'.da_type = datype.id', 'left');
        $this->db->join('department', $this->_table.'.department = department.id', 'left');
        $this->db->join('product', 'daitems.product = product.id', 'left');
        
        if(!empty($where)) {
             $this->db->where($where);
        }
        
        if(!empty($conditionsCheckArray)){
            $this->db->where($conditionsCheckArray);
        }
       
        $this->db->where($this->_table.'.financial_year', $this->session->userdata('financial_year'));
        $this->db->group_by($this->_table.'.id'); 
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
 
}
