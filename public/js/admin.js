document.querySelectorAll('.sidebar-submenu').forEach(e => { // lấy tất cả các thẻ a có class là sidebar-submenu được chọn để chứa các dropdown
    e.querySelector('.sidebar-menu-dropdown').onclick = (event) => { // lắng nghe thằng onclick để khi click vào từng class đã được chọn để show menu-dropdown
    event.preventDefault()
    e.querySelector('.sidebar-menu-dropdown .dropdown-icon').classList.toggle('active')
    // lấy ra icon để đóng hoặc mở sidebar khi responsive hoặc khi trình duyệt bị thu nhỏ
    let dropdown_content = e.querySelector('.sidebar-menu-dropdown-content')
    // Khai báo biến dropown_content bằng cách select từng cái thẻ có chứa class sidebar-menu-dropdown-content
    let dropdown_content_lis = dropdown_content.querySelectorAll('li')
    // Khai báo biến list dropdpwm bằng select tất cả các thẻ li có trong thẻ ul chứa class dropdown_content
    let active_height = dropdown_content_lis[0].clientHeight * dropdown_content_lis.length
    // khai báo biến active để khi lắng nghe được hành động click ở class dropdown content sẽ trả về chiều cao
    // của vùng hiện thị cho đối tượng lis content,
    // để hiện ra như kiểu cái thanh cuộn trang ấy
    dropdown_content.classList.toggle('active')
    // nghe hành động ở class dropcontent được toggle để hiển hoặc ẩn các list content được hiển thị
    dropdown_content.style.height = dropdown_content.classList.contains('active') ? active_height + 'px' : '0'
    // đặt chiều cao cho danh sách content được thực hiện sau khi hành động được dropdown xảy ra, kiểu như CSS bằng JS
    }
    })
    
    let overlay = document.querySelector('.overlay')
    let sidebar = document.querySelector('.sidebar')
    
    document.querySelector('#mobile-toggle').onclick = () => {
        sidebar.classList.toggle('active')
        overlay.classList.toggle('active')
    }
    
    document.querySelector('#sidebar-close').onclick = () => {
        sidebar.classList.toggle('active')
        overlay.classList.toggle('active')
    }