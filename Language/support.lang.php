<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 04.10.2019
 * Time: 17:46
 */

return array(
    'ru' => array(

        'support_ajax_empty_tid' => 'Не передан тикет ID',
        'support_ajax_empty_category' => 'Вам необходимо выбрать «Категорию» обращения',
        'support_ajax_empty_details' => 'Не переданы детали сообшения',
        'support_ajax_empty_title' => 'Не передана Тема обращения',
        'support_ajax_empty_message' => 'Не передана Описания обращения или Комментарий',

        'title_awaiting_user' => 'Ожидают ответа',
        'title_awaiting_admin' => 'Обрабатываются',
        'title_closed' => 'Закрытые',
        'title_msg_empty' => 'Сообщений нет',

        'tabs_all_ticket' => 'Все обращения',
        'tabs_create_ticket' => 'Создать тикет',

        'btn_create_ticket_1' => 'Создать тикет',
        'btn_create_ticket_2' => 'Общие вопросы',

        'btn_create_donate_1' => 'Проблемы',
        'btn_create_donate_2' => 'с донатом',

        'btn_create_lost_1' => 'Пропали',
        'btn_create_lost_2' => 'предметы',

        'title_create_ticket' => 'Создать новый тикет в указанный департамент',

        'title_create_category_6' => 'Пропажа предметов',
        'title_create_category_7' => 'Жалоба на бота',
        'title_create_category_8' => 'Проблемы с пополнением пожертвованием',



        'form_title_category' => 'Категория',
        'form_title_account' => 'Аккаунт',
        'form_title_char' => 'Персонаж',
        'form_title_char_select' => 'Выберите персонажа',
        'error_account_char_not_found' => 'На этом аккаунте нет персонажей',
        'form_title_title' => 'Тема',
        'form_title_title_text' => 'Укажите тему сообщения',
        'form_title_title_files' => 'Прикрепить изображения
            <div style="font-size: 0.8em;">Общий размер не превышает 2&nbsp;МБ</div>
            <div style="font-size: 0.8em;">В формате JPG, GIF или PNG</div>',

        //Пропал предмет
        'form_title_sharing' => 'Был ли доступ у других игроков к вашему аккаунту?',
        'form_title_yse' => 'Да',
        'form_title_yse_text' => 'Внимание, если у других игроков был санкционированный Вами доступ к аккаунту, то украденные предметы возвращены не будут. В этом случае возможно проведение расследование и сообщение результата вам. Стоимость услуги - индивидуально',
        'form_title_no' => 'Нет',
        'form_title_no_text' => 'Внимание, если в результате расследования будет выяснено, что к аккаунту имели санкционированный Вами доступ другие игроки, то этот факт будет воспринят как попытка обмануть администрацию. В этом случае вам грозит блокировка игрового аккаунта согласно установленным правилам.',
        'form_title_protection' => 'Была ли включена защита аккаунта?',
        'form_title_loss' => 'Примерная дата пропажи',
        'form_title_contact' => 'Способ связи',
        'form_title_message_loss' => 'Укажите список пропавших предметов',
        'form_title_message_loss_desc' => 'Пропал магический меч',

        //проблема с платежом
        'form_title_payment_method' => 'Выберите платежную систему',
        'form_title_transactions' => 'Номер заказа или транзакции',
        'form_title_pay_date' => 'Дата платежа',
        'form_title_pay_time' => 'Время платежа',
        'form_title_sum' => 'Сумма платежа',
        'form_title_message_comment' => 'Комментарий',
        'form_title_message_comment_text' => 'Комментарий...',


        //найден бот
        'form_title_date' => 'Дата обнаружения нарушителя',
        'form_title_time' => 'Время',
        'form_title_bot_name' => 'Перечислите никнеймы нарушителей',
        'form_title_message_bot' => 'Комментарий, ссылка на скриншоты...',



        'form_title_message' => 'Сообщение',
        'form_title_message_text' => 'Описание проблемы...',




        'form_title_send_btn' => 'Отправить',



        'category' => array(
            //0 => 'Выберите категорию',
            1 => 'Общие вопросы',
            2 => 'Сайт, Форум, ЛК',
            3 => 'Ошибки клиента',
            4 => 'Ошибки игры',
            5 => 'Блокировка аккаунта/персонажа',
            6 => 'Пропажа предметов',
            7 => 'Жалоба на бота',
            8 => 'Проблемы с пожертвованием',
            9 => 'Прочее',
        ),

    ),
    'en' => array(
	
        'support_ajax_empty_tid' => 'Invalid ticket ID specified',
        'support_ajax_empty_category' => 'You need to select a ticket topic',
        'support_ajax_empty_details' => 'You need to provide the ticket details',
        'support_ajax_empty_title' => 'Please enter a valid subject',
        'support_ajax_empty_message' => 'Please enter a valid message',

        'title_awaiting_user' => 'Awaiting Response',
        'title_awaiting_admin' => 'Being Processed',
        'title_closed' => 'Closed',
        'title_msg_empty' => 'No tickets',

        'tabs_all_ticket' => 'All tickets',
        'tabs_create_ticket' => 'Create ticket',

        'btn_create_ticket_1' => 'Other',
        'btn_create_ticket_2' => 'Other issues & questions',

        'btn_create_donate_1' => 'Donation Issues',
        'btn_create_donate_2' => 'Issues related to donations',

        'btn_create_lost_1' => 'Item Loss',
        'btn_create_lost_2' => 'Issues related to loss of in-game items',

        'title_create_ticket' => 'Create a new ticket',

        'title_create_category_6' => 'Item Loss',
        'title_create_category_7' => 'Bot Report',
        'title_create_category_8' => 'Issues with Balance Top-ups',



        'form_title_category' => 'Topic',
        'form_title_account' => 'Game Account',
        'form_title_char' => 'Character',
        'form_title_char_select' => 'Choose a character',
        'error_account_char_not_found' => 'There are no characters on this game account.',
        'form_title_title' => 'Subject',
        'form_title_title_text' => 'Specify the subject of your ticket',
        'form_title_title_files' => 'Attach images
            <div style="font-size: 0.8em;">The total file size cannot exceed 2&nbsp;MB</div>
            <div style="font-size: 0.8em;">JPG, GIF or PNG format accepted</div>',

        //Пропал предмет
        'form_title_sharing' => 'Did other players have access to your account?',
        'form_title_yse' => 'Yes',
        'form_title_yse_text' => 'ATTENTION: If other players knowingly had access to your account, then stolen items will NOT be recovered. In cases like these, it is only possible to conduct an investigation and provide you with details on who accessed and when they accessed your account. This is a chargeable service and the price is per character.',
        'form_title_no' => 'No',
        'form_title_no_text' => 'ATTENTION: If following the investigation it is determined that other players knowingly had access to your account, then the intentionally wrongful response provided to this question will be considered as an attempt in deceiving the administration. In this case, your account will be banned in accordance with the established User Agreement.',
        'form_title_protection' => 'Have you enabled PIN-Code?',
        'form_title_loss' => 'Estimated date of item loss',
        'form_title_contact' => 'Communication method',
        'form_title_message_loss' => 'Specify a list of missing items',
        'form_title_message_loss_desc' => 'My Sword of Miracles is gone!',

        //проблема с платежом
        'form_title_payment_method' => 'Choose a Payment Method',
        'form_title_transactions' => 'Order or Transaction Number',
        'form_title_pay_date' => 'Payment Date',
        'form_title_pay_time' => 'Payment Time',
        'form_title_sum' => 'Payment Amount',
        'form_title_message_comment' => 'Details',
        'form_title_message_comment_text' => 'Details...',


        //найден бот
        'form_title_date' => 'Suspect Detection Date',
        'form_title_time' => 'Time',
        'form_title_bot_name' => 'Suspected Character Names',
        'form_title_message_bot' => 'Details, link to screenshots/videos',



        'form_title_message' => 'Message',
        'form_title_message_text' => 'Question/problem details...',




        'form_title_send_btn' => 'Submit',



        'category' => array(
            //0 => 'Choose subject',
            1 => 'General Questions',
            2 => 'Website, Forum, Master Account',
            3 => 'Client Errors',
            4 => 'Game Bugs',
            5 => 'Account/Character Ban',
            6 => 'Item Loss',
            7 => 'Bot Report',
            8 => 'Issues with Balance Top-ups',
            9 => 'Other',
        ),
	
	
	
    ),
    'gr' => array(
	
        'support_ajax_empty_tid' => 'Λανθασμένο ID αιτήματος υποστήριξης',
        'support_ajax_empty_category' => 'Πρέπει να επιλέξετε θέμα αιτήματος υποστήριξης',
        'support_ajax_empty_details' => 'Πρέπει να εισάγετε τις λεπτομέρειες του αιτήματος υποστήριξης',
        'support_ajax_empty_title' => 'Εισάγετε ένα έγκυρο τίλτο',
        'support_ajax_empty_message' => 'Εισάγετε ένα έγκυρο μήνυμα',

        'title_awaiting_user' => 'Αναμένουν Απάντηση',
        'title_awaiting_admin' => 'Σε Επεξεργασία',
        'title_closed' => 'Κλειστά',
        'title_msg_empty' => 'Κανένα αίτημα',

        'tabs_all_ticket' => 'Όλα τα αιτήματα',
        'tabs_create_ticket' => 'Υποβολή αιτήματος',

        'btn_create_ticket_1' => 'Άλλα',
        'btn_create_ticket_2' => 'Άλλα προβλήματα και ερωτήσεις',

        'btn_create_donate_1' => 'Προβλήμα με Δωρεά',
        'btn_create_donate_2' => 'Προβλήματα που σχετίζονται με τις δωρεές',

        'btn_create_lost_1' => 'Απώλεια Item',
        'btn_create_lost_2' => 'Προβλήματα που σχετίζονται με την απώλεια in-game items',

        'title_create_ticket' => 'Υποβολή νέου αιτήματος',

        'title_create_category_6' => 'Απώλεια Item',
        'title_create_category_7' => 'Αναφορά Bot',
        'title_create_category_8' => 'Πρόβλημα με Ανανέωση Υπολοίπου',



        'form_title_category' => 'Κατηγορία',
        'form_title_account' => 'Game Account',
        'form_title_char' => 'Χαρακτήρας',
        'form_title_char_select' => 'Επιλέξτε χαρακτήρα',
        'error_account_char_not_found' => 'Δεν υπάρχουν χαρακτήρες σε αυτό το game account.',
        'form_title_title' => 'Θέμα',
        'form_title_title_text' => 'Καθορίστε το θέμα του αιτήματός σας',
        'form_title_title_files' => 'Επισύναψη εικόνων
            <div style="font-size: 0.8em;">Το συνολικό μέγεθος δεν μπορεί να ξεπερνάει τα 2&nbsp;MB</div>
            <div style="font-size: 0.8em;">Αποδεκτές μορφές: JPG, GIF ή PNG</div>',

        //Пропал предмет
        'form_title_sharing' => 'Είχε κάποιος άλλος παίκτης πρόσβαση στο account σας;',
        'form_title_yse' => 'Ναί',
        'form_title_yse_text' => 'ΠΡΟΣΟΧΗ: Εάν άλλοι παίκτες είχαν πρόσβαση στο account σας εν γνώσει σας, τότε τα κλεμμένα items ΔΕΝ θα επιστραφούν. Σε τέτοιες περιπτώσεις, το μόνο που μπορούμε να σας προσφέρουμε είναι να ελέγξουμε το ιστορικό και να σας δώσουμε πληροφορίες σχετικά με το πότε και ποίος συνδέθηκε στο account. Αυτό είναι μία χρεώσιμη υπηρεσία της οποίας η τιμή είναι ανά χαρακτήρα.',
        'form_title_no' => 'Όχι',
        'form_title_no_text' => 'ΠΡΟΣΟΧΗ: Εάν ύστερα από έλεγχο διαπιστωθεί ότι άλλοι παίκτες είχαν πρόσβαση στο account σας εν γνώσει σας, τότε η εκ προθέσεως λανθασμένη απάντηση σας σε αυτή την ερώτηση θα θεωρηθεί ως απόπειρα απάτης σε βάρος της διαχείρησης. Σε αυτή την περίπτωση, το account σας θα αποκλειστεί βάσει των ισχυόντων Όρων Χρήσης.',
        'form_title_protection' => 'Έχετε ενεργοποιήσει το PIN-Code;',
        'form_title_loss' => 'Εκτιμώμενη ημερομηνία απώλειας item',
        'form_title_contact' => 'Τρόπος επικοινωνίας',
        'form_title_message_loss' => 'Ορίστε μια λίστα με τα items που λείπουν',
        'form_title_message_loss_desc' => 'Το Sword of Miracles μου χάθηκε!',

        //проблема с платежом
        'form_title_payment_method' => 'Επιλέξτε Σύστημα Πληρωμών',
        'form_title_transactions' => 'Αριθμός Παραγγελίας ή Συναλλαγής',
        'form_title_pay_date' => 'Ημερομηνία πληρωμής',
        'form_title_pay_time' => 'Ώρα πληρωμής',
        'form_title_sum' => 'Ποσό πληρωμής',
        'form_title_message_comment' => 'Λεπτομέρειες',
        'form_title_message_comment_text' => 'Λεπτομέρειες...',


        //найден бот
        'form_title_date' => 'Ημερομηνία Εντοπισμού Υπόπτου',
        'form_title_time' => 'Ώρα',
        'form_title_bot_name' => 'Ονόματα Ύποπτων Χαρακτήρων',
        'form_title_message_bot' => 'Λεπτομέρειες, link σε screenshots/videos',



        'form_title_message' => 'Μήνυμα',
        'form_title_message_text' => 'Περιγραφή ερώτησης/προβλήματος...',




        'form_title_send_btn' => 'Υποβολή',



        'category' => array(
            //0 => 'Choose subject',
            1 => 'Γενικές Ερωτήσεις',
            2 => 'Website, Forum, Master Account',
            3 => 'Προβλήματα Client',
            4 => 'Game Bugs',
            5 => 'Αποκλεισμός Account/Χαρακτήρα',
            6 => 'Απώλεια Item',
            7 => 'Αναφορά Bot',
            8 => 'Προβλήματα με Ανανεώση Υπολοίπου',
            9 => 'Άλλα',
        ),
	
	
	
	),
	'es' => array(
	
        'support_ajax_empty_tid' => 'ID de ticket especificado inválido',
        'support_ajax_empty_category' => 'Debes elegir un tema de ticket',
        'support_ajax_empty_details' => 'Debes proveer los detalles del ticket',
        'support_ajax_empty_title' => 'Por favor ingresa un asunto válido',
        'support_ajax_empty_message' => 'Por favor ingresa un mensaje válido',

        'title_awaiting_user' => 'Esperando Respuesta',
        'title_awaiting_admin' => 'Siendo procesado',
        'title_closed' => 'Cerrado',
        'title_msg_empty' => 'No hay tickets',

        'tabs_all_ticket' => 'Todos los tickets',
        'tabs_create_ticket' => 'Crear ticket',

        'btn_create_ticket_1' => 'Otros',
        'btn_create_ticket_2' => 'Otros problemas y consultas',

        'btn_create_donate_1' => 'Problemas de Donaciones',
        'btn_create_donate_2' => 'Problemas relacionados con donaciones',

        'btn_create_lost_1' => 'Pérdida de Artículos',
        'btn_create_lost_2' => 'Problemas relacionados con la pérdida de artículos dentro del juego',

        'title_create_ticket' => 'Crear un nuevo ticket',

        'title_create_category_6' => 'Pérdida de Artículos',
        'title_create_category_7' => 'Reporte de Bot',
        'title_create_category_8' => 'Problemas con recargas de Saldo',



        'form_title_category' => 'Tema',
        'form_title_account' => 'Cuenta de Juego',
        'form_title_char' => 'Personaje',
        'form_title_char_select' => 'Selecciona un personaje',
        'error_account_char_not_found' => 'No hay personajes en esta cuenta de juego.',
        'form_title_title' => 'Tema',
        'form_title_title_text' => 'Especifica el tema de tu ticket',
        'form_title_title_files' => 'Adjunta imágenes
            <div style="font-size: 0.8em;">El tamaño total del archivo no puede exceder de 2&nbsp;MB</div>
            <div style="font-size: 0.8em;">Formatos aceptados: JPG, GIF or PNG</div>',

        //Пропал предмет
        'form_title_sharing' => 'Otros jugadores han tenido acceso a tu cuenta?',
        'form_title_yse' => 'Sí',
        'form_title_yse_text' => 'ATENCIÓN: Si otros jugadores tuvieron acceso a tu cuenta a sabiendas, los artículos robados NO se recuperarán. En casos como estos, solo es posible llevar a cabo una investigación y proporcionarte detalles sobre quién accedió y cuándo accedió a tu cuenta. Este es un servicio pago y el precio es por personaje.',
        'form_title_no' => 'No',
        'form_title_no_text' => 'ATENCIÓN: Si siguiendo la investigación se determina que otros jugadores tenían acceso a tu cuenta a sabiendas, entonces, la respuesta intencionalmente ilícita proporcionada a esta pregunta se considerará un intento de engañar a la administración. En este caso, tu cuenta será prohibida de acuerdo con lo establecido en el Acuerdo de Usuario.',
        'form_title_protection' => 'Has habililitado el Código-PIN?',
        'form_title_loss' => 'Fecha estimada de la pérdida de los artículos',
        'form_title_contact' => 'Método de comunicación',
        'form_title_message_loss' => 'Especifica una lista de los artículos faltantes',
        'form_title_message_loss_desc' => 'Mi Sword of Miracles ha desaparecido!',

        //проблема с платежом
        'form_title_payment_method' => 'Elige un Método de Pago',
        'form_title_transactions' => 'Número de Orden o Transacción',
        'form_title_pay_date' => 'Fecha de Pago',
        'form_title_pay_time' => 'Hora de Pago',
        'form_title_sum' => 'Monto de Pago',
        'form_title_message_comment' => 'Detalles',
        'form_title_message_comment_text' => 'Detalles...',


        //найден бот
        'form_title_date' => 'Fecha de Detección del Sospechoso',
        'form_title_time' => 'Hora',
        'form_title_bot_name' => 'Nombres de los Personajes Sospechos',
        'form_title_message_bot' => 'Detalles, vínculos a capturas de pantalla/videos',



        'form_title_message' => 'Mensaje',
        'form_title_message_text' => 'Detalles de la pregunta/problema...',




        'form_title_send_btn' => 'Enviar',



        'category' => array(
            //0 => 'Choose subject',
            1 => 'Preguntales Generales',
            2 => 'Sitio Web, Foro, Cuenta Maestra',
            3 => 'Errores del Cliente',
            4 => 'Errores del juego',
            5 => 'Ban de Cuenta/Personaje',
            6 => 'Pérdida de Artículos',
            7 => 'Reporte de Bot',
            8 => 'Problemas con Recargas de Saldo',
            9 => 'Otros',
        ),
	
	
	
    ),
    'pt' => array(
    
        'support_ajax_empty_tid' => 'ID de ticket inválido especificado ',
        'support_ajax_empty_category' => 'Você precisa selecionar um tópico de ticket',
        'support_ajax_empty_details' => 'Você precisa fornecer os detalhes do ticket',
        'support_ajax_empty_title' => 'Por favor insira um assunto válido',
        'support_ajax_empty_message' => 'Por favor insira uma mensagem válida',

        'title_awaiting_user' => 'Esperando resposta',
        'title_awaiting_admin' => 'Sendo processado',
        'title_closed' => 'Fechado',
        'title_msg_empty' => 'Sem tickets',

        'tabs_all_ticket' => 'Todos os tickets',
        'tabs_create_ticket' => 'Criar um ticket',

        'btn_create_ticket_1' => 'Outro',
        'btn_create_ticket_2' => 'Outros problemas e questões',

        'btn_create_donate_1' => 'Problemas de doação',
        'btn_create_donate_2' => 'Questões relacionadas a doações',

        'btn_create_lost_1' => 'Perda de item',
        'btn_create_lost_2' => 'Problemas relacionados à perda de itens do jogo',

        'title_create_ticket' => 'Criar um novo ticket',

        'title_create_category_6' => 'Perda de item',
        'title_create_category_7' => 'Denúncia de Bot',
        'title_create_category_8' => 'Problemas com recargas de saldo',

        'form_title_category' => 'Tópico',
        'form_title_account' => 'Conta do jogo',
        'form_title_char' => 'Personagem',
        'form_title_char_select' => 'Escolha o personagem',
        'error_account_char_not_found' => 'Não há personagens nesta conta de jogo.',
        'form_title_title' => 'Assunto',
        'form_title_title_text' => 'Especifique o assunto do seu ticket',
        'form_title_title_files' => 'Anexar imagens
            <div style="font-size: 0.8em;">O tamanho total do arquivo não pode exceder 2&nbsp;MB</div>
            <div style="font-size: 0.8em;">Formatos JPG, GIF ou PNG aceitos</div>',

        //Пропал предмет
        'form_title_sharing' => 'Outros jogadores tiveram acesso à sua conta?',
        'form_title_yse' => 'Sim',
        'form_title_yse_text' => 'ATENÇÃO: Se outros jogadores intencionalmente tiveram acesso à sua conta, os itens roubados NÃO serão recuperados. Em casos como esse, só é possível conduzir uma investigação e fornecer detalhes sobre quem acessou e quando acessou sua conta. Este é um serviço pago e o preço é por personagem.',
        'form_title_no' => 'Não',
        'form_title_no_text' => 'ATENÇÃO: Se após a investigação for determinado que outros jogadores intencionalmente tiveram acesso à sua conta, a resposta intencionalmente errada fornecida a esta questão será considerada uma tentativa de enganar a administração. Neste caso, sua conta será banida de acordo com o Acordo de Usuário estabelecido.',
        'form_title_protection' => 'Você habilitou o código PIN?',
        'form_title_loss' => 'Data estimada de perda do item',
        'form_title_contact' => 'Método de comunicação',
        'form_title_message_loss' => 'Especifique uma lista de itens perdidos',
        'form_title_message_loss_desc' => 'Minha Sword of Miracles foi levada!',

        //проблема с платежом
        'form_title_payment_method' => 'Escolha um método de pagamento',
        'form_title_transactions' => 'Pedido ou número de transação',
        'form_title_pay_date' => 'Data do pagamento',
        'form_title_pay_time' => 'Hora do pagamento',
        'form_title_sum' => 'Valor de Pagamento',
        'form_title_message_comment' => 'Detalhes',
        'form_title_message_comment_text' => 'Detalhes...',

        //найден бот
        'form_title_date' => 'Data de detecção suspeita',
        'form_title_time' => 'Hora',
        'form_title_bot_name' => 'Nomes de personagens suspeitos',
        'form_title_message_bot' => 'Detalhes, link para capturas de tela/vídeos',

        'form_title_message' => 'Mensagem',
        'form_title_message_text' => 'Detalhes da pergunta/problema...',


        'form_title_send_btn' => 'Enviar',


        'category' => array(
            //0 => 'Choose subject',
            1 => 'Questões gerais',
            2 => 'Website, Forum, Conta Mestre',
            3 => 'Erros no cliente do jogo',
            4 => 'Bugs do jogo',
            5 => 'Banimento de conta/personagem ',
            6 => 'Perda de item',
            7 => 'Denúncia de bot',
            8 => 'Problemas com recargas de saldo',
            9 => 'Outros',
        ),
    
    
    ),
	'cn' => array(
	
        'support_ajax_empty_tid' => '指定的票证ID无效',
        'support_ajax_empty_category' => '您需要选择票证主题',
        'support_ajax_empty_details' => '您需要提供机票详细信息',
        'support_ajax_empty_title' => '请输入有效的主题',
        'support_ajax_empty_message' => '请输入有效消息',

        'title_awaiting_user' => '正在等待响应',
        'title_awaiting_admin' => '正在处理的问题',
        'title_closed' => '已关闭',
        'title_msg_empty' => '没有门票',

        'tabs_all_ticket' => '所有门票',
        'tabs_create_ticket' => '创建票证',

        'btn_create_ticket_1' => '其他的',
        'btn_create_ticket_2' => '其他问题和问题',

        'btn_create_donate_1' => '捐赠问题',
        'btn_create_donate_2' => '与捐款有关的问题',

        'btn_create_lost_1' => '物品损失',
        'btn_create_lost_2' => '与游戏中物品丢失有关的问题',

        'title_create_ticket' => '创建新票证',

        'title_create_category_6' => '物品损失',
        'title_create_category_7' => '机器人报告',
        'title_create_category_8' => '平衡顶盖的问题',



        'form_title_category' => '主题',
        'form_title_account' => '游戏帐号',
        'form_title_char' => '人物',
        'form_title_char_select' => '选择角色',
        'error_account_char_not_found' => '这个游戏帐户上没有任何角色.',
        'form_title_title' => '主题',
        'form_title_title_text' => '指定票证的主题',
        'form_title_title_files' => '附加图像
            <div style="font-size: 0.8em;">文件总大小不能超过2&nbsp;MB</div>
            <div style="font-size: 0.8em;">接受JPG、GIF或PNG格式</div>',

        //Пропал предмет
        'form_title_sharing' => '其他玩家是否可以访问您的帐户?',
        'form_title_yse' => '是的',
        'form_title_yse_text' => '注意：如果其他玩家明知有权访问您的帐户，那么被盗物品将无法追回。在这样的情况下,只能进行调查,并向您提供有关访问对象和访问您的帐户的详细信息。这是一项收费服务，价格为每人.',
        'form_title_no' => '没有',
        'form_title_no_text' => '注意事项：如果在调查之后确定其他参与者明知有权访问您的帐户，那么对该问题的故意错误答复将被视为企图欺骗管理部门。在这种情况下,您的帐户将根据既定的用户协议被禁止.',
        'form_title_protection' => '是否启用了PIN码?',
        'form_title_loss' => '物品损失估计日期',
        'form_title_contact' => '沟通方式',
        'form_title_message_loss' => '指定缺少项目的列表',
        'form_title_message_loss_desc' => '我的奇迹之剑不见了!',

        //проблема с платежом
        'form_title_payment_method' => '选择付款方式',
        'form_title_transactions' => '订单或交易编号',
        'form_title_pay_date' => '付款日期',
        'form_title_pay_time' => '付款时间',
        'form_title_sum' => '付款金额',
        'form_title_message_comment' => '详细资料',
        'form_title_message_comment_text' => '详细资料...',


        //найден бот
        'form_title_date' => '可疑侦测日期',
        'form_title_time' => '时间',
        'form_title_bot_name' => '疑似人物姓名',
        'form_title_message_bot' => '详细信息,指向屏幕截图/视频的链接',



        'form_title_message' => '信息',
        'form_title_message_text' => '问题/问题细节...',




        'form_title_send_btn' => '提交',



        'category' => array(
            //0 => 'Choose subject',
            1 => '一般问题',
            2 => '网站、论坛、总帐户',
            3 => '客户端错误',
            4 => 'Game Bugs',
            5 => '帐户/字符禁令',
            6 => '物品损失',
            7 => '机器人报告',
            8 => '平衡顶盖的问题',
            9 => '其他的',
        ),
	
	
	
    ),
	'ko' => array(
	
        'support_ajax_empty_tid' => '잘못된 티켓 ID가 지정',
        'support_ajax_empty_category' => '티켓 주제를 선택해야합니다',
        'support_ajax_empty_details' => '티켓 세부 정보를 제공해야합니다',
        'support_ajax_empty_title' => '유효한 주제를 입력하십시오',
        'support_ajax_empty_message' => '유효한 메시지를 입력하십시',

        'title_awaiting_user' => '응답 대기 중',
        'title_awaiting_admin' => '처리 중',
        'title_closed' => '닫힘',
        'title_msg_empty' => '티켓 없음',

        'tabs_all_ticket' => '모든 티켓',
        'tabs_create_ticket' => '티켓 만들기',

        'btn_create_ticket_1' => '다른 사람',
        'btn_create_ticket_2' => '다른 문제 및 질문',

        'btn_create_donate_1' => '기부 문제',
        'btn_create_donate_2' => '기부와 관련된 문제',

        'btn_create_lost_1' => '품목 손실',
        'btn_create_lost_2' => '게임 내 아이템 손실과 관련된 문제',

        'title_create_ticket' => '새 항공권 만들기',

        'title_create_category_6' => '품목 손실',
        'title_create_category_7' => '봇 보고서',
        'title_create_category_8' => '밸런스 탑업 문제',



        'form_title_category' => '주제',
        'form_title_account' => '게임 계정',
        'form_title_char' => '캐릭터',
        'form_title_char_select' => '캐릭터 선택',
        'error_account_char_not_found' => '이 게임 계정에는 캐릭터가 없습니다.',
        'form_title_title' => '주제',
        'form_title_title_text' => '항공권의 주제를 지정하십시오',
        'form_title_title_files' => '그림 첨부
            <div style="font-size: 0.8em;">전체 파일 크기가 2를 초과할 수 없습니&nbsp;MB</div>
            <div style="font-size: 0.8em;">JPG, PI 또는 PNG형식이 허용됩니다</div>',

        //Пропал предмет
        'form_title_sharing' => '다른 플레이어가 귀하의 계정에 액세스 할 수?',
        'form_title_yse' => '예',
        'form_title_yse_text' => '방법: 다른 플레이어가 의도적으로 귀하의 계정에 액세스 할 수 있다면 도난당한 아이템은 복구되지 않습니다. 이와 같은 경우 조사를 수행하고 계정에 액세스 한 사람 및시기에 대한 세부 정보를 제공 할 수 있습니다. 이것은 청구 가능한 서비스이며 가격은 문자 당.',
        'form_title_no' => '아니요',
        'form_title_no_text' => '결정: 조사 후 다른 플레이어가 의도적으로 귀하의 계정에 액세스 할 수 있다고 판단되면, 이 질문에 제공된 의도적으로 잘못된 응답은 행정부를 속이려는 시도로 간주됩니다. 이 경우 기존 사용자 계약에 따라 계정이 금지됩니다..',
        'form_title_protection' => 'PIN 코드를 활성화 했습니까??',
        'form_title_loss' => '품목 손실 예상 날짜',
        'form_title_contact' => '통신 방법',
        'form_title_message_loss' => '누락 된 항목 목록 지정하기',
        'form_title_message_loss_desc' => '내 기적의 검이 사라졌습니다!',

        //проблема с платежом
        'form_title_payment_method' => '결제 방법 선택',
        'form_title_transactions' => '주문 또는 거래 번호',
        'form_title_pay_date' => '결제 날짜',
        'form_title_pay_time' => '결제 시간',
        'form_title_sum' => '결제 금액',
        'form_title_message_comment' => '세부 사항',
        'form_title_message_comment_text' => '세부 사항...',


        //найден бот
        'form_title_date' => '용의자 탐지 날짜',
        'form_title_time' => '시간',
        'form_title_bot_name' => '의심되는 문자 이름',
        'form_title_message_bot' => '세부 사항, 스크린 샷/비디오 링크',



        'form_title_message' => '메시지',
        'form_title_message_text' => '질문/문제 세부 사항...',




        'form_title_send_btn' => 'Submit',



        'category' => array(
            //0 => 'Choose subject',
            1 => '일반적인 질문',
            2 => '웹 사이트, 포럼, 마스터 계정',
            3 => '클라이언트 오',
            4 => '게임 버그',
            5 => '계정/문자 금지',
            6 => '품목 손실',
            7 => '봇 보고서',
            8 => '밸런스 탑업 문제',
            9 => '다른 사람',
        ),
	
	
	
    ),
);