<?php

namespace App\Enums;

class Constant
{
  //    STATUS CODE
  const SUCCESS_CODE              = 200;
  const FALSE_CODE                = false;
  const CREATED_CODE              = 201;
  const ACCEPTED_CODE             = 202;
  const NO_CONTENT_CODE           = 204;
  const BAD_REQUEST_CODE          = 400;
  const UNAUTHENTICATED_CODE         = 401;
  const FORBIDDEN_CODE            = 403;
  const NOT_FOUND_CODE            = 404;
  const METHOD_NOT_ALLOWED_CODE   = 405;
  const HTTP_UNPROCESSABLE_ENTITY   = 422;
  const INTERNAL_SV_ERROR_CODE    = 500;

  const DISTANCE_MAP_NOT_FOUND    = 'NOT_FOUND';

  // ORDERING
  const ORDER_BY                  = 20;
  const PER_PAGE                  = 20;

  // MAX SIZE FILE
  const MAX_SIZE_FILE             = 5242880;

  const TIME_CANCEL_TICKET = 10; //minutes
  // FIREBASE NOTIFY TYPE
  const FCM_FIREBASE_URI          = 'https://fcm.googleapis.com/fcm/send';

  //PATH FOLDER
  const PATH_PROFILE              = 'profile';
  const PATH_ROAD                 = 'road';
  const PATH_MERCHANDISES         = 'merchandises';
  const PATH_CATEGORY             = 'categories';
  const PATH_UPLOAD               = 'uploads';
  const PATH_LIBRARY              = 'libraries';
  const PATH_MESSAGE              = 'message';
  const PATH_STATION              = 'station';
  const PATH_NEWS                 = 'news';
  const PATH_PROMOTION            = 'promotions';
  const PATH_PAGE_INTRODUCTION    = 'page-introduction';

  const LOGO_PATH                 = 'http://188.166.232.154/_next/image?url=%2F_next%2Fstatic%2Fmedia%2Flogo_giv.8e897856.png&w=384&q=75';

  //URL call api  website ticket
  const URI_WEB_TICKET = 'http://eticket.thanhcongbus.vn/api-ve/web/';
  const URL_LIST_OF_ROUTES = Constant::URI_WEB_TICKET . 'tuyen-xe';
  const URL_TRIP_LIST = Constant::URI_WEB_TICKET . 'danh-sach-chuyen';
  const URL_INFO_TRIP = Constant::URI_WEB_TICKET . 'thong-tin-xe';
  const URL_CHAR_LIST = Constant::URI_WEB_TICKET . 'so-do-xe';
  const URL_CHAR_PLACED = Constant::URI_WEB_TICKET . 'ghe-da-dat';
  const URL_PICK_DROP_TRIP = Constant::URI_WEB_TICKET . 'diem-don-tra';
  const URL_PICK_TICKET_SUBMIT = Constant::URI_WEB_TICKET . 'dat-cho';
  const URL_CANCEL_TICKET = Constant::URI_WEB_TICKET . 'huy-dat-cho';
  const URL_EDIT_TICKET = Constant::URI_WEB_TICKET . 'sua-dat-cho';
  const URL_GET_INFO_TRIP = Constant::URI_WEB_TICKET . 'kiem-tra-dat-cho';
  // URL SPP PAYMENT
  const URI_SPP_UAT = 'https://api.uat.wallet.airpay.vn/';
  const SPP_CREATE_QRCODE = Constant::URI_SPP_UAT . 'v3/merchant-host/qr/create';
  const SPP_DISABLE_QRCODE = Constant::URI_SPP_UAT . 'v3/merchant-host/qr/invalidate';
  const SPP_CHECK_ORDER = Constant::URI_SPP_UAT . 'v3/merchant-host/transaction/check';
  const SPP_REFUND = Constant::URI_SPP_UAT . 'v3/merchant-host/transaction/refund/create-new';
  const SPP_CREATE_ORDER = Constant::URI_SPP_UAT . 'v3/merchant-host/order/create';
  const SPP_DISABLE_ORDER = Constant::URI_SPP_UAT . 'v3/merchant-host/order/invalidate';
}
