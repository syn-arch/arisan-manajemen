<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require './vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Auth extends CI_Controller {

	public function index()
	{
		if ($this->session->userdata('login')) {
			redirect('dashboard','refresh');
		}

		$valid = $this->form_validation;

		$valid->set_rules('email', 'email', 'required');
		$valid->set_rules('password', 'password', 'required');
		$valid->set_message('required', 'Kolom wajib diisi');

		if ($valid->run()) {
			$post = $this->input->post();

			$this->db->join('role', 'id_role', 'left');
			$petugas = $this->db->get_where('petugas', ['email' => $post['email']])->row_array();

			if ($petugas) {

				if (password_verify($post['password'], $petugas['password'])) {

					$session = [
						'login' => true,
						'id_petugas' => $petugas['id_petugas'],
						'id_role' => $petugas['id_role'],
						'id_outlet' => $petugas['id_outlet'],
						'nama_petugas' => $petugas['nama_petugas'],
						'level' => $petugas['nama_role']
					];

					$this->session->set_userdata($session);

					if ($petugas['id_outlet']) {
						redirect('penjualan','refresh');
					}
					redirect('dashboard','refresh');
					
				} else {
					$this->session->set_flashdata('error', 'Password anda salah');
					redirect('login','refresh');
				}
				
			}else{
				$this->session->set_flashdata('error', 'Email tidak ditemukan');
				redirect('login','refresh');
			}
		}

		$this->load->view('auth/login');
	}

	public function logout($value='')
	{
		$this->session->sess_destroy();
		redirect('login','refresh');
	}

	private function _send_email($token, $email)
	{
		$pengaturan = $this->db->get('pengaturan')->row_array();

		$mail = new PHPMailer(true);
		try {
		    //Server settings
		    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                     
			$mail->isSMTP();                                           
			$mail->Host       = $pengaturan['smtp_host'];                   
			$mail->SMTPAuth   = true;                                  
			$mail->Username   = $pengaturan['smtp_email'];                    
			$mail->Password   = $pengaturan['smtp_password'];                        
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;        
			$mail->Port       = 465;                                   

		    //Recipients
			$mail->setFrom('noreply@mail.com', 'E-POS');
			$mail->addAddress($email);    

		    // Content
			$mail->isHTML(true);  
			$mail->Subject = 'Lupa Password';
			$mail->Body    = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Lupa Password</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                    <tr>
                        <td align="center" bgcolor="#70bbd9" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                            <img target="_blank" src="http://epos.smkbbc.sch.id/assets/img/favicon.png" alt="Lupa Password" width="300" height="300" style="display: block;" />
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                        <b>Lupa Password</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                       Klik tautan dibawah untuk mengatur ulang password anda!
                                    </td>
                                </tr>
                                <tr>
                                	<td><a href="' . base_url('auth/verify?email='. $email . '&token=' . $token) . '">RESET PASSWORD</a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';

			$mail->send();

		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}

	public function lupa_password()
	{
		$this->form_validation->set_rules('email', 'email', 'required');

		if ($this->form_validation->run()) {

			$petugas = $this->db->get_where('petugas', ['email' => $this->input->post('email')])->row_array();

			if ($petugas) {

				$token = acak(32);

				$token_petugas = [
					'id_petugas' => $petugas['id_petugas'],
					'token' => $token
				];

				$this->db->insert('token_petugas', $token_petugas);

				$this->_send_email($token, $petugas['email']);

				$this->session->set_flashdata('message', 'Periksa email anda untuk mengatur ulang password anda');
				redirect('login','refresh');
			}else{
				$this->session->set_flashdata('error', 'Email tidak ditemukan!');
				redirect('auth/lupa_password','refresh');
			}

		}

		$this->load->view('auth/lupa_password');
	}

	public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $petugas = $this->db->get_where('petugas', ['email' => $email])->row_array();

        if ($petugas) {
            $token_petugas = $this->db->get_where('token_petugas', ['token' => $token])->row_array();

            if ($token_petugas) {
                $this->session->set_userdata('reset_email', $email);
                $this->changePassword();
            } else {
                $this->session->set_flashdata('error', 'Lupa Password Gagal, Token Salah');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('error', 'Lupa Password Gagal, Email Tidak Ditemukan');
            redirect('auth');
        }
    }

     public function changePassword()
    {
    	 if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

        $this->form_validation->set_rules('pw1', 'Password Baru', 'trim|required|matches[pw2]');
        $this->form_validation->set_rules('pw2', 'Konfirmasi Password', 'trim|required|matches[pw1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('reset_password');
        } else {
            $password = password_hash($this->input->post('pw1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $petugas = $this->db->get('petugas', ['email' => $email])->row_array();

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('petugas');

            $this->session->unset_userdata('reset_email');

            $this->db->delete('token_petugas', ['id_petugas' => $petugas['id_petugas']]);

            $this->session->set_flashdata('message', 'Password berhasil diubah, silahkan login kembali');
            redirect('auth');
        }
    }
}

/* End of file Auth.php */
/* Location: ./application/modules/auth/controllers/Auth.php */ ?>