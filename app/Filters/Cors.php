<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CORS implements FilterInterface
{
    /**
     * Do whatever processing you wish here.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Set header Access-Control-Allow-Origin
        // Anda bisa mengganti '*' dengan origin spesifik dari frontend Anda,
        // misalnya 'http://localhost:5173' atau 'http://localhost'
        header('Access-Control-Allow-Origin: *'); // Atau 'http://localhost:5173'
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
        header('Access-Control-Allow-Credentials: true'); // Jika Anda menggunakan kredensial/cookies

        // Tangani preflight OPTIONS request
        if ($request->getMethod() == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
            }
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }
            exit(0); // Penting: Hentikan eksekusi script setelah OPTIONS
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method can also be used to filter
     * global content from the Header and Footer of the Response
     * object.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada yang perlu dilakukan di sini untuk CORS sederhana
    }
}