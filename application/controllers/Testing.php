<?php

class Testing extends PHPIEM_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function Index()
	{
		$this->load->model('appsmodel');
		echo $this->_generate_code_ticket();
		// echo $this->appsmodel->testmodel();
		// $olddatas = $this->appsmodel->oldregister();
		// var_dump( $this->appsmodel->get_option('migration_queue') );
	}

	private function migration_data()
	{
		$this->load->model('appsmodel');
		$olddatas = $this->appsmodel->oldregister();
		$pqueue = $this->appsmodel->get_option('migration_queue');

		if ( $pqueue == '' ){
			$prepare = [];
			foreach ($olddatas as $qk => $qval){
				$prepare[] = $qval['id'];
			}
			$this->appsmodel->add_option('migration_queue', serialize($prepare));
			$migproc = true;
			$curproc = $prepare[0];
			$queue = $prepare;
		} elseif ($pqueue == 'done') {
			$migproc = false;
			$curproc = '';
		} else {
			$queue = unserialize($pqueue);
			$migproc = true;
			$curproc = $queue[0];
		}

		if ( $migproc && $curproc != '' ){
			foreach ($olddatas as $k => $val) {
				if ( $val['id'] == $curproc ) {
					$datausr = [
						'reg_date' 		=> $val["tgl"], 
						'login_name' 	=> $val["email"], 
						'full_name' 	=> $val["nama"], 
						'email' 		=> $val["email"], 
						'city' 			=> $val["kota"], 
						'isactive' 		=> true, 
						'isadmin' 		=> false, 
						'deleted' 		=> false, 
						'status' 		=> "Active"
					];

					$dataorder = [
						'event_id' 		=> 1,
						'price' 		=> ( strtolower( $val["kategori"] ) == "student" ) ? 75000 : 100000,
						'ticket_code' 	=> $val["kode"],
						'order_date' 	=> $val["tgl"],
						'paid_date' 	=> $val["tglbayar"],
						'deleted' 		=> false,
						'status' 		=> ( $val["tglbayar"] != null ) ? 'Payment Accepted' : 'Waiting Payment'
					];

					$dum = [
						'handphone'	=> $val['hp'],
						'alamat' 	=> $val['alamat'],
						'instansi'	=> '',
						'kategori'	=> $val["kategori"],
						'icon'		=> ( $val['icon'] == null ) ? '' : 'Green Shirt'
					];

					if ( $this->appsmodel->migrasidata($datausr, $dum, $dataorder) ) {
						if ( count($queue) == 1 ){
							$this->appsmodel->update_option('migration_queue', 'done');
							exit('Done');
						}
						else {
							unset( $queue[0] );
							$r = array_values($queue);
							$this->appsmodel->update_option('migration_queue', serialize($r));
							redirect(site_url('testing/migration-data'), 'refresh');
						}
					} else {
						exit('error: on queue #' . $queue[0]);
					}
				}
			}
		}
	}

	public function sending_ticket_all()
	{
		$this->load->model('appsmodel');
		$tickets = $this->appsmodel->get_option('sending_bulk_tickets');
		if ($tickets == '')
		{
			$alltickets = $this->appsmodel->loadallticketcode(1);
			$this->appsmodel->add_option('sending_bulk_tickets', serialize($alltickets));
			$queueticket = $alltickets;
			$sendproc = true;
			$curproc = $queueticket[0];
		} else {
			if ( $tickets != 'done' ){
				$queueticket = unserialize($tickets);
				$sendproc = true;
				$curproc = $queueticket[0];
			} else {
				$queueticket = [];
				$sendproc = false;
				$curproc = '';
			}
		}

		if ($queueticket != null && $sendproc && $curproc != '')
		{
			foreach($queueticket as $ticket)
			{
				if ( $ticket == $curproc)
				{
					if ( $this->_sending_ticket($ticket) )
					{
						unset( $queueticket[0] );
						$nextqueue = array_values($queueticket);
						$this->appsmodel->update_option('sending_bulk_tickets', serialize($nextqueue));
						redirect(site_url('testing/sending-ticket-all'), 'refresh');
					} else {
						die('sending error!');
					}
				} else {
					die('ticket code error!');
				}
			}
		} else {
			die('data ticket error!');
		}
	}
}
