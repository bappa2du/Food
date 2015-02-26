<?php
    App::uses('AppController', 'Controller');

    /**
     * Cities Controller
     *
     * @property City $City
     * @property PaginatorComponent $Paginator
     */
    class ChefCareersController extends AppController
    {
		var $uses = array('ChefCareer');
		
		/*
		 |---------------------Chef Career Entry Form-----------------|
		 |------------------------------------------------------------|
		 */
		public function myCareer()
		{
            /*
            |--------------------------------------------------------------------------
            | Save data
            |--------------------------------------------------------------------------
            */
            if ($this->request->is ( 'post' ))
            {
            	ini_set('memory_limit',-1);
            	
                $this->ChefCareer->create ();
                
                if ($this->ChefCareer->save ( $this->request->data )) 
                {
                    $id = $this->ChefCareer->getLastInsertId();
                    
                    $email = $this->request->data['ChefCareer']['email'];
                    
                    $name = $this->request->data['ChefCareer']['name'];
                    
                    $chefCareer = $this->ChefCareer->read(null, $id); 
                    
                    $resume = "";
                    
	                if (strlen ( trim ( $chefCareer ['ChefCareer'] ['image_dir'] ) ) > 0) {
						$resume = WWW_ROOT.'/files/chef_career/image/' . $chefCareer ['ChefCareer'] ['id'] . '/' . $chefCareer ['ChefCareer'] ['image'];
	                }
                    try 
                    {
                    	$Email = new CakeEmail('gmail');//JOB_EMAIL_RECEPIANT
                    	 
                    	$Email->template ( 'career', 'default' )->
                    			replyTo($email, $name)->
                    			from ( JOB_EMAIL_RECEPIANT, 'CHEFGENIE' )->
                    			to ( JOB_EMAIL_RECEPIANT )->
                    			subject ( 'ChefGenie Job Application' )->
                    			emailFormat ( 'html' )->
                    			attachments ( array($resume) )->
                    			viewVars ( array (
                    			'career' => $chefCareer
                    			) 
                    	);
                    	if ($Email->send ())
                    	{
                    		$this->set('email_sent', 1);
                    		
                    		$this->set('form_id', $id);
                    		
                    		$this->set('form_email', $email);
                    	}
                    	else
                    	{
                    		$this->ChefCareer->id = $id;
                    		
                    		$this->ChefCareer->delete();
                    		
                    		$this->set('email_sent', 0);
                    	}
                    }
                    catch ( Exception $e ) 
                    {
                    	$this->ChefCareer->id = $id;
                    	
                    	$this->ChefCareer->delete();
                    	
                    	$this->set('email_sent', 2);
                    	
                    	$this->set('error', $e);
                    }
                    
                } else {
                	$this->set('email_sent', 2);
                }
            }
		}

        public function edit()
        {
            $this->loadModel('ChefCareer');
            if(isset($this->request->data['id']))
            {
                $id = $this->request->data['id'];
                $email = $this->request->data['email'];


                $query = "SELECT * FROM chef_careers WHERE id = '$id' AND email = '$email'";
                $result = $this->ChefCareer->query($query);
                if(empty($result)){$result = 0;}
                return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($result)));
            }

            if($this->request->is('post') || $this->request->is('put')) {

                $this->ChefCareer->id = $this->request->data['ChefCareer']['id'];
                
                if ($this->ChefCareer->save($this->request->data)) 
                {

                	$email = $this->request->data['ChefCareer']['email'];
                	
                	$name = $this->request->data['ChefCareer']['name'];
                	
                	$chefCareer = $this->ChefCareer->read(null, $id); 
                    
                    $resume = "";
                    
	                if (strlen ( trim ( $chefCareer ['ChefCareer'] ['image_dir'] ) ) > 0) {
						$resume = WWW_ROOT.'/files/chef_career/image/' . $chefCareer ['ChefCareer'] ['id'] . '/' . $chefCareer ['ChefCareer'] ['image'];
	                }
                    try 
                    {
                    	$Email = new CakeEmail('gmail');//JOB_EMAIL_RECEPIANT
                    	 
                    	$Email->template ( 'career', 'default' )->
                    			replyTo($email, $name)->
                    			from ( JOB_EMAIL_RECEPIANT, 'CHEFGENIE' )->
                    			to ( JOB_EMAIL_RECEPIANT )->
                    			subject ( 'ChefGenie Job Application' )->
                    			emailFormat ( 'html' )->
                    			attachments ( array($resume) )->
                    			viewVars ( array (
                    			'career' => $chefCareer
                    			) 
                    	);
                		if ($Email->send ())
                		{
                			$this->set('email_sent', 1);
                	
                			$this->set('form_id', $this->request->data['ChefCareer']['id']);
                	
                			$this->set('form_email', $email);
                		}
                		else
                		{
                			$this->ChefCareer->id = $this->request->data['ChefCareer']['id'];
                	
                			$this->ChefCareer->delete();
                	
                			$this->set('email_sent', 0);
                		}
                	}
                	catch ( Exception $e )
                	{
                		$this->set('email_sent', 2);
                	}
                	
                } 
                else {
                	$this->set('email_sent', 2);
                }
        }
        }
        
        
        function chefContact()
        {
        	if($this->request->is('post'))
        	{
        		$to_email = $this->request->data['Webpage']['to'];
        		$fromEmail = $this->request->data['Webpage']['from'];
        		$subject = $this->request->data['Webpage']['message_subject'];
        		$message = $this->request->data['Webpage']['message_body'];
        		$name = $this->request->data['Webpage']['name'];
        
        		try {
        			$Email = new CakeEmail('gmail');
        			
        			$Email->template ( 'career', 'default' )->replyTo($fromEmail, $name)->from ( $to_email, 'CHEFGENIE' )->to ( $to_email )->subject ( 'ChefGenie Job Applicatio' )->emailFormat ( 'html' )->viewVars ( array (
        					'career' => $chefCareer
        			) );
        			if ($Email->send ($message))
        			{
        				$this->set('email_sent', 1);
        			}
        			else
        			{
        				$this->set('email_sent', 0);
        			}
        		} catch ( Exception $e ) {
        			$this->set('email_sent', 2);
        		}
        	}
        }

        function currentOpening(){}
		
    }
